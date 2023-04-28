<div class="user-information">
    <div class="user-img">
        <a href="#"><img src="<?= isset($user['profile_img']) ? base_url('assets/landing-pages/images/avatar/'.$user['profile_img']) : base_url('assets/landing-pages/images/uploads/user-img.png') ?>" alt=""><br></a>
        <a href="#" class="redbtn" id="change-avatar">Change avatar</a>
    </div>
    <div class="user-fav">
        <p>Account Details</p>
        <ul>
            <li><a href="<?=base_url('user')?>#user-profile">Profile</a></li>
            <li  class="active"><a href="<?=base_url('user/user_favorite_list')?>">Favorite Books</a></li>
            <li  class="active"><a href="<?=base_url('user/book_list')?>">Books On Loan</a></li>
        </ul>
    </div>
    <div class="user-fav">
        <p>Others</p>
        <ul>
            <li><a href="<?=base_url('user')?>#change-password">Change password</a></li>
            <li><a href="<?=base_url('user/logout')?>">Log out</a></li>
        </ul>
    </div>
</div>