<li class="chat">
    <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="Chatbot Image" class="chatbot-image">
    <div class="incoming">
        <p>Thank you . Please fill out the form first so that we can connect with you.</p>
    </div>
</li>
<li class="chat outgoing form">
    <form novalidate id="frm-user-details">
        <div class="form-group">
            <input class="form-control" type="text" name="full_name" id="full_name" placeholder="Enter Your Name" required>
            <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required>
            <button type="submit" class="btn">Submit</button>
        </div>
    </form>
</li>
<li class="chat outgoing d-none" id="user-submitted">
    <div class="extra">
        <span><i class="fa-sharp fa-solid fa-circle-check" style="color: #32ba7c;margin-right: 5px;"></i>Submitted</span>
    </div>
</li>
<li class="chat d-none" id="thank-you">
    <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="Chatbot Image" class="chatbot-image">
    <div class="incoming">

        <p>Thank you for chating with us :)</p>
    </div>
</li>
<?php /**PATH /var/www/netreach2/resources/views/chatbot/ajax/thank_you.blade.php ENDPATH**/ ?>