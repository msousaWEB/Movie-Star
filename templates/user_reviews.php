<?php
    require_once("models/user.php");
    $userModel = new User();
    $fullName = $userModel->getFullName($review->user);
    //Checar se tem img de perfil
    if($review->user->image == ""){
        $review->user->image = "user.png";
    }
?>

<!--Comentários-->
<div class="col-md-12 review">
    <div class="row">
            <div class="profile-image-container review-image" style="background-image: url('<?=$app?>img/users/<?=$review->user->image?>')"></div>
            <div class="col author-details-container">
                <h4 class="author-name"><a href="<?=$app?>profile.php?id=<?=$review->user->id?>"><?=$fullName?></a></h4>
                <p><i class="fas fa-star"></i><?=$review->rating?></p>
            </div>
            <div class="col-md-9" style="padding-top: 20px;">
                <p class="coment-title">Comentário:</p>
                <p><?=$review->review?></p>
            </div>
    </div>
</div>