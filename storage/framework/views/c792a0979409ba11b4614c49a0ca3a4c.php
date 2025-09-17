<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
 
<body>
    <script src="<?php echo e(asset('assets/vendor/jquery/dist/jquery.min.js')); ?>"></script>
    <div id="google_translate_element"> </div>
    <button class="send">send</button>
    <div class="translatethis"></div>
    <script type="text/javascript">
        const lang = "ta";
        const states = <?php echo json_encode($district); ?>;
        // console.log(states);
        states.forEach(element => {
            const x = document.createElement("h1");
            x.setAttribute('data-id', element.id);
            x.textContent = element.address;
            // x.textContent = element.state_name;
            $(".translatethis").append(x)
        });
        jsonData = []
        $(".send").click(() => {
            const h1s = $(".translatethis").find("h1")
 
            h1s.each((index, ss) => {
                id = $(ss).data('id')
                text = $(ss).text()
                // console.log(text);
 
                jsonData.push({
                    id: id,
                    payload: text
                });
            });
            console.log(jsonData);
 
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            // console.log(csrf_token);
 
 
            console.log(jsonData);
            $.ajax({
                url: 'http://127.0.0.1:8000/translator', // API endpoint
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: csrf_token,
                    jsonData: JSON.stringify(jsonData),
                    lang:lang
                },
                success: function(response) {
                    console.log('Success:', response); // Handle success
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Handle error
                }
            });
        })
 
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,as,bn,bho,gu,hi,kn,gom,mai,doi,ml,mr,mni-Mtei,or,pa,sa,sd,ta,te,ur'
            }, 'google_translate_element');
 
            setTimeout(() => {
                const selectElement = document.querySelector('.goog-te-combo');
 
                if (selectElement) {
 
                    if (lang != 'en') {
                        selectElement.value = lang;
                        selectElement.dispatchEvent(new Event('change'));
                    }
                }
            }, 400);
 
            setTimeout(() => {
                const googlePanel = document.querySelector('.skiptranslate');
 
                if (googlePanel) {
                    googlePanel.style.display = 'none';
                }
            }, 400);
 
        }
        $(document).ready(function() {
            const reloadGoogleTranslateScript = () => {
                if (!$('#google_translate_element').html().trim()) {
                    const existingScript = document.getElementById('scriptx');
                    if (existingScript) {
                        existingScript.remove();
                    }
 
                    const newScript = document.createElement('script');
                    newScript.type = 'text/javascript';
                    newScript.id = 'scriptx';
                    newScript.src =
                        '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                    document.body.appendChild(newScript);
                }
 
            }
 
 
 
 
            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'visible') {
                    googleTranslateElementInit();
                    reloadGoogleTranslateScript();
 
                }
            });
            window.onload = () => {
                setTimeout(() => {
                    // const newScript = document.createElement('script');
                    // newScript.type = 'text/javascript';
                    // newScript.id = 'scriptx';
                    // newScript.src =
                    //     '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                    // document.body.appendChild(newScript);
                    googleTranslateElementInit();
                    reloadGoogleTranslateScript();
                    console.log("sgfdg");
 
                }, 400);
            }
        });
    </script>
 
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
</body>
 
</html>
 <?php /**PATH /var/www/netreach2/resources/views/testscript.blade.php ENDPATH**/ ?>