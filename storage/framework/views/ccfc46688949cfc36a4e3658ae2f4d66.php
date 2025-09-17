<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo e(App::isProduction() ? secure_asset('assets/css/chatbot.css') : asset('assets/css/chatbot.css')); ?>">
    <title>Chatbot</title>
</head>

<body>
    <h1>Chatbot</h1>

    <div class="chatbot-toggler">
        <img style="width: 75%" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="">
        <i class="close-icon fa-solid fa-xmark fa-2xl" style="display: none;"></i>
    </div>

    <div class="chatbot" style="display: none;">
        <header>
            <img style="width: 50px;margin-left:5px;margin-right:5px" class="header-image" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="Hello, I'm Malini Didi">
            <div class="header-greeting ms-2">
                <span>Hello</span>
                <span>I'm Malini Didi</span>
            </div>
            <i class="refresh-icon me-5 fa-sharp fa-solid fa-rotate-right fa-xl"></i>
        </header>

        <div class="modal" style="display: none;">
            <div class="modal-content">
                <p>You want to start the chat again?</p>
                <div class="button-group">
                    <button class="btn cancel-btn">Cancel</button>
                    <button class="btn confirm-btn">Confirm</button>
                </div>
            </div>
        </div>

        <ul class="chatbox" id="chatbox">
            <li class="chat" style="margin-top: 20px;">
                <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="Chatbot Image" class="chatbot-image">
                <div class="incoming">
                    <p>Please select your preferred language from the options below</p>
                </div>
            </li>
            <?php
            use App\Models\LanguageModule\Language;
            ?>
            <li class="chat outgoing">
                <div class="languages">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="locale" data-value="<?php echo e($language[Language::locale]); ?>"><?php echo e($language[Language::name]); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </li>
            <section id="chatbot"></section>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js')); ?>"></script>
</body>

</html>
<?php /**PATH /var/www/netreach2/resources/views/chatbot/index.blade.php ENDPATH**/ ?>