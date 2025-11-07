/* eslint-env jquery */
/* global Vimeo */
$(function() {
    'use strict';

    var output = $('.output');

    function getFormattedMessage(message) {
        var className = typeof message;

        if (message === null || className === 'undefined') {
            return '';
        }

        if (className === 'string') {
            message = '"' + message + '"';
        }

        if (className === 'object') {
            message = JSON.stringify(message, null, 4).replace(/\n/g, '<br>');
        }

        return '<span class="' + className + '">' + message + '</span>';
    }

    function replaceUrls(string) {
        var matches = string.match(/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/ig);

        if (matches && matches.length) {
            for (var i = 0, length = matches.length; i < length; i++) {
                string = string.replace(matches[i], '<a href="' + matches[i] + '" target="_blank">' + matches[i] + '</a>');
            }
        }

        return string;
    }

    function replaceColors(string) {
        var matches = string.match(/#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})/g);

        if (matches && matches.length) {
            for (var i = 0, length = matches.length; i < length; i++) {
                string = string.replace(matches[i], '<span class="color-link" data-color="' + matches[i].substr(1) + '">' + matches[i] + '</span>');
            }
        }

        return string;
    }

    function apiLog(label, message, options) {
        options = options || {};

        if (!options.preFormatted) {
            message = getFormattedMessage(message);
        }

        if (message !== '') {
            message = ': ' + message;
        }

        // Give it a small cushion for Chrome because it will sometimes be off by a pixel or two.
        var wasScrolledToEnd = output.scrollTop() >= (output.prop('scrollHeight') - output.innerHeight()) - 4;

        output.get(0).insertAdjacentHTML('beforeend', '<p class="' + (options.className || '') + '">' + label + message + '</p>');

        if (wasScrolledToEnd) {
            output.prop('scrollTop', output.prop('scrollHeight'));
        }
        else if (options.scrollToEnd) {
            output.animate({ scrollTop: output.prop('scrollHeight') }, 'fast');
        }
    }

    function makeGetterCallback(label) {
        return function(value) {
            // Escape HTML in returned strings
            if (typeof value === 'string') {
                value = value.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }

            apiLog(label, value, {
                className: 'getter',
                scrollToEnd: true
            });
        };
    }

    function makeEventCallback(eventName) {
        return function(data) {
            // Progress event
            if (data && 'seconds' in data) {
                return apiLog(eventName + ' event', getFormattedMessage(data.seconds) + ' seconds (' + (data.percent * 100).toFixed(1) + '%)', {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Volumechange event
            if (data && 'volume' in data) {
                return apiLog(eventName + ' event', getFormattedMessage(data.volume), {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Cuechange & texttrackchange events
            if (data && 'label' in data) {
                var message = '';

                if ('cues' in data) {
                    for (var cue in data.cues) {
                        message += data.cues[cue].text;
                    }
                }

                return apiLog(eventName + ' event (' + data.language + '-' + data.kind + ')', message, {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Cuepoint
            if (data && 'time' in data && 'data' in data) {
                return apiLog(eventName + ' event (' + data.time + ')', getFormattedMessage(data.data), {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Chapter
            if (data && 'startTime' in data && 'title' in data) {
                return apiLog(eventName + ' event (' + data.startTime + ')', getFormattedMessage(data), {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Loaded event
            if (data && 'id' in data) {
                return apiLog(eventName + ' event', getFormattedMessage(data.id), {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Interactivity events
            if (data && 'action' in data) {
                return apiLog(eventName + ' event', getFormattedMessage(data.id), {
                    className: 'event',
                    preFormatted: true
                });
            }

            // Error event
            if (data && data.message) {
                // Ignore 360° getCameraProps error events because
                // it would log an error for non-360° videos.
                if (data.method === 'getCameraProps') return;

                return logError(data);
            }

            apiLog(eventName + ' event', null, {
                className: 'event'
            });
        };
    }

    function logError(data) {
        data.message = replaceUrls(data.message);
        data.message = replaceColors(data.message);

        return apiLog(data.name, data.message, {
            className: 'error',
            preFormatted: true
        });
    }

    function getEventPrefs() {
        try {
            return JSON.parse(window.localStorage.getItem('vimeo-player-api-demo')) || {};
        }
        catch (e) {
            return {};
        }
    }

    function storeEventPref(event, on) {
        try {
            var prefs = getEventPrefs();
            prefs[event] = on;
            window.localStorage.setItem('vimeo-player-api-demo', JSON.stringify(prefs));
        }
        catch (e) {
            // empty
        }
    }


    // Store references to the setter inputs
    var loopInput = $('#loop-checkbox');
    var autopauseInput = $('#autopause-checkbox');
    var colorInput = $('#color-input');
    var randomColorButton = $('#random-color-button');
    var defaultColorButton = $('#default-color-button');
    var colorOneInput = $('#color-one-input');
    var randomColorOneButton = $('#random-color-one-button');
    var defaultColorOneButton = $('#default-color-one-button');
    var colorTwoInput = $('#color-two-input');
    var randomColorTwoButton = $('#random-color-two-button');
    var defaultColorTwoButton = $('#default-color-two-button');
    var colorThreeInput = $('#color-three-input');
    var randomColorThreeButton = $('#random-color-three-button');
    var defaultColorThreeButton = $('#default-color-three-button');
    var colorFourInput = $('#color-four-input');
    var randomColorFourButton = $('#random-color-four-button');
    var defaultColorFourButton = $('#default-color-four-button');
    var setColorsInput = $('#set-colors-input');
    var setColorsButton = $('#set-colors-button');
    var randomColorsButton = $('#random-colors-button');
    var defaultColorsButton = $('#default-colors-button');
    var currentTimeRange = $('#current-time-range');
    var currentTimeSecond = $('#current-time-second'); //순진
    var currentTimeInput = $('#current-time-input');
    var currentTimeButton = $('#current-time-button');

    var chk_ended = $('#chk_ended'); //순진
    var textTrackSelect = $('#text-track-select');
    var qualitySelect = $('#quality-select');
    var volumeInput = $('#volume-range');
    var videoIdInput = $('#video-id');
    var loadVideoButton = $('#load-button');
    var cuePointInput = $('#add-cuepoint');
    var addCuePointButton = $('#add-cuepoint-button');
    var playbackRateButton = $('#playback-rate-button');
    var playbackRateInput = $('#playback-rate-input');
    var muteButton = $('#mute-button');
    var unmuteButton = $('#unmute-button');
    var fullscreenButton = $('#fullscreen-button');
    var yawInput = $('#yaw-range');
    var pitchInput = $('#pitch-range');
    var rollInput = $('#roll-range');
    var fovInput = $('#fov-range');
    var pipButton = $('#pip-button');

    const colorLegacyDefault = '00adef';
    const colorOneDefault = '000000';
    const colorTwoDefault = '00adef';
    const colorThreeDefault = 'ffffff';
    const colorFourDefault = '000000';

    // Check if we have actual color input support
    var colorInputSupport = false;
    if (colorInput.prop('type') === 'color') {
        colorInputSupport = true;
        $('body').addClass('color-input-support');
    }

    var eventCallbacks = {
        play: makeEventCallback('play'),
        playing: makeEventCallback('playing'),
        pause: makeEventCallback('pause'),
        ended: makeEventCallback('ended'),
        timeupdate: makeEventCallback('timeupdate'),
        progress: makeEventCallback('progress'),
        seeking: makeEventCallback('seeking'),
        seeked: makeEventCallback('seeked'),
        volumechange: makeEventCallback('volumechange'),
        texttrackchange: makeEventCallback('texttrackchange'),
        cuechange: makeEventCallback('cuechange'),
        chapterchange: makeEventCallback('chapterchange'),
        error: makeEventCallback('error'),
        loaded: makeEventCallback('loaded'),
        cuepoint: makeEventCallback('cuepoint'),
        ratechange: makeEventCallback('ratechange'),
        qualitychange: makeEventCallback('qualitychange'),
        bufferstart: makeEventCallback('bufferstart'),
        bufferend: makeEventCallback('bufferend'),
        fullscreenchange: makeEventCallback('fullscreenchange'),
        enterpictureinpicture: makeEventCallback('enterpictureinpicture'),
        leavepictureinpicture: makeEventCallback('leavepictureinpicture'),
        loadedmetadata: makeEventCallback('loadedmetadata'),
        durationchange: makeEventCallback('durationchange'),
        waiting: makeEventCallback('waiting'),
        loadeddata: makeEventCallback('loadeddata'),
        loadstart: makeEventCallback('loadstart'),
        resize: makeEventCallback('resize'),
        interactivehotspotclicked:  makeEventCallback('interactivehotspotclicked'),
        interactiveoverlaypanelclicked: makeEventCallback('interactiveoverlaypanelclicked')
    };

    // Create the player
    var player = new Vimeo.Player($('iframe'));
    window.demoPlayer = player;

    // Log when the player is ready
    player.ready().then(function() {
        apiLog('ready event', null, {
            className: 'event'
        });
    }).catch(logError);

    // Listen for the events that are checked off
    var eventPrefs = getEventPrefs();
    Object.keys(eventCallbacks).forEach(function(eventName) {
        if (eventPrefs[eventName] !== false) {
            player.on(eventName, eventCallbacks[eventName]);
        }
    });

    // Get the id and set the input
    player.getVideoId().then(function(videoId) {
        videoIdInput.val(videoId).prop('disabled', false);
        loadVideoButton.prop('disabled', false);
    }).catch(logError);

    player.getCuePoints().then(function(cuePoints) {
        cuePointInput.prop('disabled', false);
        addCuePointButton.prop('disabled', false);
    }).catch(logError);

    // Get the loop state and enable the checkbox
    player.getLoop().then(function(loop) {
        loopInput.prop('checked', loop).prop('disabled', false);
    }).catch(logError);

    // Get the autopause state and enable the checkbox
    player.getAutopause().then(function(autopause) {
        autopauseInput.prop('checked', autopause).prop('disabled', false);
    }).catch(logError);

    // Get the color, update the input, and enable
    function handleGetColor(color, input, randomButton, defaultButton) {
        input.val('#' + color).prop('disabled', false);
        randomButton.prop('disabled', false);
        defaultButton.prop('disabled', false);
    }
    function handleGetColors(colors) {
        const [colorOne, colorTwo, colorThree, colorFour] = colors;
        handleGetColor(colorOne, colorOneInput, randomColorOneButton, defaultColorOneButton);
        handleGetColor(colorTwo, colorTwoInput, randomColorTwoButton, defaultColorTwoButton);
        handleGetColor(colorThree, colorThreeInput, randomColorThreeButton, defaultColorThreeButton);
        handleGetColor(colorFour, colorFourInput, randomColorFourButton, defaultColorFourButton);
    }
    player.getColor().then(function(color) {
        handleGetColor(color, colorInput, randomColorButton, defaultColorButton);
    }).catch(logError);
    player.getColors().then(function(colors) {
        handleGetColors(colors);
    }).catch(logError);

    // Get the duration to set the range properly
    player.getDuration().then(function(duration) {
        currentTimeRange.prop('max', duration);
        currentTimeInput.prop('max', duration).prop('disabled', false);
        currentTimeButton.prop('disabled', false);
    }).catch(logError);

    // Get text track info
    player.getTextTracks().then(function(tracks) {
        if (tracks.length) {
            for (var track in tracks) {
                track = tracks[track];
                textTrackSelect.append('<option value="' + track.language + '.' + track.kind + '"' + (track.mode === 'showing' ? ' selected' : '') + '>' + track.label + '</option>');
            }

            textTrackSelect.prop('disabled', false);
        }
    }).catch(logError);

    player.getQualities().then(function(data) {
        if (data.length) {
            for (var key in data) {
                var item = data[key];
                qualitySelect.append('<option value="' + item.id + '"' + (item.active ? ' selected' : '') + '>' + item.label + '</option>');
            }

            qualitySelect.prop('disabled', false);
        }
    }).catch(logError);

    // Get the volume and enable the slider
    player.getVolume().then(function(volume) {
        volumeInput.val(volume).prop('disabled', false);
    }).catch(logError);

    player.getCameraProps().then(function(data) {
        $('.spatial-setters').show();

        yawInput.val(data.yaw);
        pitchInput.val(data.pitch);
        fovInput.val(data.fov);
    }).catch(() => {});

    player.getPlaybackRate().then(function(playbackRate) {
        playbackRateInput.val(playbackRate).prop('disabled', false);
        playbackRateButton.prop('disabled', false);
    }).catch(logError);

    // Listen for timeupdate to update the time range input
    player.on('timeupdate', function(data) {
       
       currentTimeRange.val(data.seconds); 
       currentTimeSecond.val((data.percent * 100).toFixed(0) + '%');
    });

//순진
    player.on('ended', function() {
        player.exitFullscreen();
        $('#chk_ended').attr("value", "시청완료");
       // player.destroy();                    

    });


    // Also update the time range input on seeked
    player.on('seeked', function(data) {
        currentTimeRange.val(data.seconds);
    });

    // Listen for volumechange to update the volume range input
    player.on('volumechange', function(data) {
        volumeInput.val(data.volume);
    });

    player.on('camerachange', function(data) {
        yawInput.val(data.yaw);
        pitchInput.val(data.pitch);
        fovInput.val(data.fov);
    });

    // Listen for texttrackchange to update the text tracks dropdown
    player.on('texttrackchange', function(data) {
        var id = data.language + '.' + data.kind;

        if (data.language === null) {
            id = 'none';
        }

        textTrackSelect.val(id);
    });

    player.on('qualitychange', function(data) {
        qualitySelect.val(data.quality);
    });

    // Check off the appropriate events based on preference
    $('.js-event-listener').each(function() {
        var checkbox = $(this);
        var eventName = checkbox.attr('data-event');

        if (eventPrefs[eventName] !== false) {
            checkbox.attr('checked', '');
        }
    });

    // Enable all the buttons and checkboxes
    $('.js-method, .js-getter, .js-event-listener').prop('disabled', false);


    // Clear the log when the button is clicked
    $('.clear').on('click', function() {
        output.html('');
    });


    // Setter inputs
    loopInput.on('change', function(event) {
        player.setLoop(event.target.checked);
    });

    autopauseInput.on('change', function(event) {
        player.setAutopause(event.target.checked);
    });

    function handleColorInput() {
        $(this).removeClass('invalid');
    }
    colorInput.on('input', handleColorInput);
    colorOneInput.on('input', handleColorInput);
    colorTwoInput.on('input', handleColorInput);
    colorThreeInput.on('input', handleColorInput);
    colorFourInput.on('input', handleColorInput);

    function colorSetterPromise(color, index) {
        let setter = 'setColor';
        let colorArg = color;

        if (typeof index === 'number') {
            setter = 'setColors';
            colorArg = new Array(4);
            colorArg[index] = color;
        }

        return player[setter](colorArg);
    }

    function handleColorChangeOrBlur(defaultColor, input, index) {
        var color = $(input).val();

        if (color === '') {
            color = defaultColor;
            $(this).val('#' + color);
        }

        colorSetterPromise(color, index).catch(function() {
            input.addClass('invalid');
        });
    }
    colorInput.on(colorInputSupport ? 'change' : 'blur', function() {
        handleColorChangeOrBlur(colorLegacyDefault, colorInput);
    });
    colorOneInput.on(colorInputSupport ? 'change' : 'blur', function() {
        handleColorChangeOrBlur(colorOneDefault, colorOneInput, 0);
    });
    colorTwoInput.on(colorInputSupport ? 'change' : 'blur', function() {
        handleColorChangeOrBlur(colorTwoDefault, colorTwoInput, 1);
    });
    colorInput.on(colorInputSupport ? 'change' : 'blur', function() {
        handleColorChangeOrBlur(colorThreeDefault, colorThreeInput, 2);
    });
    colorInput.on(colorInputSupport ? 'change' : 'blur', function() {
        handleColorChangeOrBlur(colorFourDefault, colorFourInput, 3);
    });

    function getRandomColor() {
        var min = 1048576;
        var max = 16777215;
        return Math.floor(Math.random() * (max - min) + min).toString(16);
    }

    function handleRandomColorClick(input, index) {
        var color = getRandomColor();

        colorSetterPromise(color, index).then(function(actualColor) {
            if (Array.isArray(actualColor)) {
                actualColor = actualColor[index];
            }
            input.val('#' + actualColor).removeClass('invalid');
        }).catch(function() {
            input.addClass('invalid');
        });
    }
    randomColorButton.on('click', function() {
        handleRandomColorClick(colorInput);
    });
    randomColorOneButton.on('click', function() {
        handleRandomColorClick(colorOneInput, 0);
    });
    randomColorTwoButton.on('click', function() {
        handleRandomColorClick(colorTwoInput, 1);
    });
    randomColorThreeButton.on('click', function() {
        handleRandomColorClick(colorThreeInput, 2);
    });
    randomColorFourButton.on('click', function() {
        handleRandomColorClick(colorFourInput, 3);
    });

    randomColorsButton.on('click', function() {
        const colors = [getRandomColor(), getRandomColor(), getRandomColor(), getRandomColor()];

        player.setColors(colors).then(function(actualColors) {
            actualColors[0] && colorOneInput.val('#' + actualColors[0]).removeClass('invalid');
            actualColors[1] && colorTwoInput.val('#' + actualColors[1]).removeClass('invalid');
            actualColors[2] && colorThreeInput.val('#' + actualColors[2]).removeClass('invalid');
            actualColors[3] && colorFourInput.val('#' + actualColors[3]).removeClass('invalid');
        });
    });

    function handleDefaultColorButtonClick(defaultColor, input, index) {
        input.val('#' + defaultColor).removeClass('invalid');
        colorSetterPromise(defaultColor, index).catch(function() {
            input.addClass('invalid');
        });
    }

    defaultColorButton.on('click', function() {
        handleDefaultColorButtonClick(colorLegacyDefault, colorInput);
    });
    defaultColorOneButton.on('click', function() {
        handleDefaultColorButtonClick(colorOneDefault, colorOneInput, 0);
    });
    defaultColorTwoButton.on('click', function() {
        handleDefaultColorButtonClick(colorTwoDefault, colorTwoInput, 1);
    });
    defaultColorThreeButton.on('click', function() {
        handleDefaultColorButtonClick(colorThreeDefault, colorThreeInput, 2);
    });
    defaultColorFourButton.on('click', function() {
        handleDefaultColorButtonClick(colorFourDefault, colorFourInput, 3);
    });

    defaultColorsButton.on('click', function() {
        colorOneInput.val('#' + colorOneDefault).removeClass('invalid');
        colorTwoInput.val('#' + colorTwoDefault).removeClass('invalid');
        colorThreeInput.val('#' + colorThreeDefault).removeClass('invalid');
        colorFourInput.val('#' + colorFourDefault).removeClass('invalid');
        player.setColors([colorOneDefault, colorTwoDefault, colorThreeDefault, colorFourDefault]);
    });

    setColorsButton.on('click', function() {
        const inputValue = setColorsInput.val();
        const inputArray = inputValue.split(',')
            .map((hex) => {
                hex = hex.replace('\'', '').trim();
                if (hex === 'null') {
                    return null;
                }
                if (hex.length === 3) {
                    return hex + hex;
                }
                return hex;
            });
        player.setColors(inputArray).then(function(actualColors) {
            actualColors[0] && colorOneInput.val('#' + actualColors[0]).removeClass('invalid');
            actualColors[1] && colorTwoInput.val('#' + actualColors[1]).removeClass('invalid');
            actualColors[2] && colorThreeInput.val('#' + actualColors[2]).removeClass('invalid');
            actualColors[3] && colorFourInput.val('#' + actualColors[3]).removeClass('invalid');
        });
    });

    output.on('click', '.color-link', function() {
        var color = $(this).attr('data-color');

        colorInput.val('#' + color).removeClass('invalid');
        player.setColor(color).catch(function() {
            colorInput.addClass('invalid');
        });
    });

    currentTimeRange.on('change', function() {
        player.setCurrentTime($(this).val());
    });

    currentTimeButton.on('click', function() {
        player.setCurrentTime(currentTimeInput.val()).catch(function() {
            currentTimeInput.addClass('invalid');
        });
    });

    textTrackSelect.on('change', function() {
        var id = $(this).val().split('.');

        if (id[0] === 'none') {
            player.disableTextTrack();
            return;
        }

        player.enableTextTrack(id[0], id[1]);
    });

    qualitySelect.on('change', function() {
        player.setQuality($(this).val());
    });

    volumeInput.on('change', function() {
        player.setVolume($(this).val());
    });

    yawInput.on('input', function() {
        player.setCameraProps({ yaw: $(this).val() });
    });

    pitchInput.on('input', function() {
        player.setCameraProps({ pitch: $(this).val() });
    });

    rollInput.on('input', function() {
        player.setCameraProps({ roll: $(this).val() });
    });

    fovInput.on('input', function() {
        player.setCameraProps({ fov: $(this).val() });
    });

    muteButton.on('click', function() {
        player.setMuted(true);
    });

    unmuteButton.on('click', function() {
        player.setMuted(false);
    });

    playbackRateButton.on('click', function() {
        player.setPlaybackRate(playbackRateInput.val()).catch(function() {
            playbackRateInput.addClass('invalid');
        });
    });

    fullscreenButton.on('click', function() {
        player.requestFullscreen();
       // setTimeout(() => {
       //     player.exitFullscreen();
       // }, 3000);
    });

    pipButton.on('click', function() {
        player.requestPictureInPicture();
        setTimeout(() => {
            player.exitPictureInPicture();
        }, 3000);
    });

    // Method buttons
    $('.js-methods').on('click', '.js-method', function() {
        var button = $(this);
        var method = button.attr('data-method');

        if (player[method]) {
            player[method]();
        }
    });

    loadVideoButton.on('click', function() {
        player.loadVideo(videoIdInput.val()).catch(function() {
            videoIdInput.addClass('invalid');
        });
    });

    addCuePointButton.on('click', function() {
        player.addCuePoint(cuePointInput.val()).then(function() {
            cuePointInput.removeClass('invalid');
            cuePointInput.val('');
        }).catch(function() {
            cuePointInput.addClass('invalid');
        });
    });

    // Getter buttons
    $('.js-getters').on('click', '.js-getter', function() {
        var button = $(this);
        var getter = button.attr('data-getter');
        var name = button.text();

        if (player[getter]) {
            player[getter]().then(makeGetterCallback(name)).catch(logError);
        }
    });

    // Event listener checkboxes
    $('.js-event-listeners').on('change', '.js-event-listener', function() {
        var checkbox = $(this);
        var eventName = checkbox.attr('data-event');

        if (checkbox.prop('checked')) {
            player.on(eventName, eventCallbacks[eventName]);
            storeEventPref(eventName, true);
        }
        else {
            player.off(eventName, eventCallbacks[eventName]);
            storeEventPref(eventName, false);
        }
    });

});
