$(document).ready(function summernoteSandbox() {
    var $editor = $('.summernote');

    var enteredText, decoded, sanitized = null;

    $editor.summernote({
        disableResizeEditor: true,
        codeviewFilter: true,
        codeviewIframeFilter: true,
        height: 200,
        maximumImageFileSize: 1048576,
        callbacks:{
            onImageUploadError: function uploadImageError(msg){
                /**
                 **  This will need to be handled better.
                 **  We can create a plugin to override the image picker if need be.
                 **  Based on CM4, the WPF app will resize accordingly so the only
                 **  considertation here will be performance.
                 **/
                alert(msg);
            }
        },
        toolbar: [
            ['operation', ['undo', 'redo']],
            ['para', ['ul', 'ol', 'paragraph','h1']],
            ['insert', ['picture', 'hr']],
            ['view', ['codeview']],
        ],



    })
    $('#preview-div').hide();


    $('#get-data').click(() => {
        // Sample strings for sanitaztion testing
        // <img src=x onerror=alert(1)//>
        // <svg><g/onload=alert(2)//<p>
        // <p>abc<iframe//src=jAvaTab;script:alert(3)>

        var userEntry = getSanitizedText();
        $('#preview-div').show();
        $('#preview-click').html(decode(userEntry));
        $('#preview-plain').text(userEntry);
    });

    $('#reset-data').click(() => {
        $('.summernote').summernote('reset');
        resetVars();
        $('#preview-div').hide();
        $('#preview-click').html('');
        $('#preview-plain').text('');
    });

    function getSanitizedText(){
        resetVars();
        enteredText = $('.summernote').summernote('code');
        decoded = decode(enteredText);
        sanitized = DOMPurify.sanitize(decoded);
        return encode(sanitized);
    }

    function decode(text) {
        return $("<textarea/>").html(text).text();
    }

    function encode(text) {
        var textArea = document.createElement('textarea');
        textArea.innerText = text;
        return textArea.innerHTML;
    }

    function resetVars(){
        enteredText = null;
        decoded = null;
        sanitized = null;
    }
});
$('.summernote').summernote('fontSize', 22)

