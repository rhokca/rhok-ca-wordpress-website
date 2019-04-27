<?php 
  $projectPhoto = get_field('photo_gallery');
?>
<div class="photo-gallery-container">


  <!-- Image Gallery -->
    <style>
    main > .container:first-child{
      padding-top: 10px!important;
    }
    .photo-gallery-container{
      margin-bottom: 20px;
    }
    .photo-gallery{
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-gap: 2px;
      padding: 1px;
    }
    .photo-gallery .photo-featured{
      grid-column: 1/4;
      grid-row: 1/4;
      justify-self: center;
      align-self: center;
    }
    .photo-gallery:nth-child(odd) .photo-featured{
      grid-column: 3 / 6;
      grid-row: 1/4;
      justify-self: center;
      align-self: center;
    }
    .photo-gallery img{
      width: 100%;
      border-radius: 0;
      height: auto;
      display: block;
    }
    .photo-gallery img:hover{
      cursor:pointer;
    }
    </style>
    

    <?php 
    for ($i = 0; $i < count($projectPhoto); $i++) {
      $url = $projectPhoto[$i]["sizes"]["project-photo-gallery"];

      if($i % 7 == 0){
        print '<section class="photo-gallery">';
      }

      if($i % 7 == 0){
        print '<img class="photo photo-featured" src="'.$url.'">';
      } else {
        print '<img class="photo" src="'.$url.'">';
      }

      if($i % 7 == 6){
        print '</section>';
      }
    } 
    ?>

    <script>
    var container = document.querySelector('.photo-gallery');
    var photos = container.querySelectorAll('.photo');
    document.body.addEventListener('click', function(e){
      if(e.target.classList.contains('photo')){
        e.target.parentNode.querySelector('.photo-featured').src = e.target.src;
        //e.target.classList.add('photo-featured');
      }
    });

    // setInterval(function(){ 
    //   var rand = Math.floor(Math.random() * (photos.length - 1)) + 0  ;
    //   container.querySelector('.photo-featured').src = photos[rand].src;
    // }, 3000);
    </script>



</div>
