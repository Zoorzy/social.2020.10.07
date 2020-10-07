<style>
  .fa {
    font-size: 2.2em;
  }

  .fa-thumbs-down,
  .fa-thumbs-o-down {
    transform: rotateY(180deg);
  }

  i {
    color: #ff5500;
  }

  #likes,
  #dislikes {
    float: left;
    width: 50%;
    padding: 20px;
    text-align: center;
    font-size: 30px;
  }
</style>

<?php
if (isset($_GET['post_id']) && !is_nan($_GET['post_id'])) {

  require "options/header.opt.php";
  include('includes/setlikevalue.inc.php');
  require "includes/DBConnection.inc.php";
?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <?php

  $post_id = $_GET['post_id'];
  $sql = "SELECT * FROM posts WHERE id='$post_id'";

  if ($result = $conn->query($sql)) {

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $image = $row['image'];
        $user_id = $row['user_id'];
        $image_src = "upload/user" . $user_id . "/" . $image;

        $user_table = $conn->query("SELECT username FROM users WHERE user_id='" . $user_id . "'")->fetch_assoc();
  ?>

        <div id="bg_image"></div>

        <div id="responsive">

          <form>
            <img src="<?php echo $image_src ?>" data-id="<?php echo $row['id'] ?>">

            <div class="post-rating-info">
              
            <div style="text-align: center;"><h2 style="color: black;padding: 20px; background-color: rgba(255,255,255, .4);">By "<?php echo $user_table['username'] ?>"</h2></div>

              <div id='likes'>
                <!-- if user likes post, style button differently -->
                <i <?php if (userLiked($row['id'])) : ?> class="fa fa-thumbs-up like-btn" <?php else : ?> class="fa fa-thumbs-o-up like-btn" <?php endif ?> data-id="<?php echo $row['id'] ?>"></i>
                <span class="likes"><?php echo getLikes($row['id']); ?></span>
                <!-- fine likes -->
                <?php //echo $row['id'] . " - " . $_SESSION['user_id']; 
                ?>
              </div>

              <div id='dislikes'>
                <!-- if user dislikes post, style button differently -->
                <i <?php if (userDisliked($row['id'])) : ?> class="fa fa-thumbs-down dislike-btn" <?php else : ?> class="fa fa-thumbs-o-down dislike-btn" <?php endif ?> data-id="<?php echo $row['id'] ?>"></i>
                <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
                <!-- fine dislikes -->
              </div>

            </div>

            <div class="clearfix"></div>

            <div id="text">

              <?php if ($_SESSION['user_id'] == $row['user_id']) { ?>
                <textarea id="textarea" style="float: left;"> <?php echo $row['text'] ?></textarea>
              <?php } else { ?>
                <div>
                  <div>
                    <?php echo '<span>' . $row['text'] . '</span>' ?>
                  </div>
                </div>
              <?php } ?>

            </div>

            <div class="clearfix"></div>

            <!-- UPDATE POST -->
            <?php
            if ($user_id == $_SESSION['user_id']) {

            ?>

              <div style="width: 50%; float: left; text-align: center;">

                <input type="button" id="update_post" name="update_post" value="Update Post" />

                <div style="width: 100%; text-align: center;">
                  <p>
                    <?php if (isset($_GET['update'])) {
                      if ($_GET['update'] == 'success') {
                        echo "update success";
                      } else if ($_GET['update'] == 'error') {
                        echo "an error occurred while updating";
                      }
                    } ?>
                  </p>
                </div>

                <script>
                  $(document).ready(function() {
                    $('#update_post').click(function() {

                      var textarea = $('#textarea').val();
                      var post_id = $('form').find('img').data('id');

                      $.post('includes/updatepost.inc.php', {
                        text: textarea,
                        id: post_id,
                        update_post: true
                      }, function(result) {
                        $("body").html(result);
                      });
                    });
                  });
                </script>

              </div>

              <!-- FINE UPDATE POST -->

              <!-- DELETE POST -->

              <div style="width: 50%; float: left; text-align: center;">

                <input type="button" id="delete_post" name="delete_post" value="Delete Post" />

                <script>
                  $(document).ready(function() {
                    $('#delete_post').click(function() {

                      var post_id = $('form').find('img').data('id');
                      var image_src = $('form').find('img').attr('src');

                      $.post('includes/deletepost.inc.php', {
                        id: post_id,
                        delete_post: true,
                        image_src: image_src
                      }, function(result) {
                        $("body").html(result);
                        $("#bg_image").hide();
                      });
                    });
                  });
                </script>

              </div>

              <!-- FINE DELETE POST -->
            <?php
            }
            ?>

          </form>

        </div>

        <script>
          function parallax() {
            var s = document.getElementById("bg_image");
            var yPos = 0 - window.pageYOffset / 2;
            s.style.top = 10 + yPos + "%";
          }

          $(document).ready(function() {
            parallax();
          });

          $(window).scroll(function() {
            parallax();
          });
        </script>

        <style>
          #bg_image {
            position: absolute;
            z-index: 0;
            background-image: url('<?php echo $image_src ?>');
            background-repeat: no-repeat;
            background-position-x: center;
            width: 100%;
            height: 100%;
            -webkit-filter: blur(7px);
            -moz-filter: blur(7px);
            -o-filter: blur(7px);
            -ms-filter: blur(7px);
            filter: blur(7px);
          }

          #responsive {
            position: relative;
            left: 0;
            right: 0;
            z-index: 2;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 15px;
          }

          img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            max-width: 500px;
            height: auto;
            margin-bottom: 10px;
          }

          #text {
            width: 75%;
            max-width: 450px;
            margin: 20px auto;
          }

          #text>* {
            text-align: center;
            margin: 10px auto;
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 5px;
          }
        </style>
        <link rel="stylesheet" href="assets/css/post.php.css">

  <?php }
    } else if (isset($_GET['delete'])) {

      echo "<div style='width: 100%; text-align: center; margin-top: 20px'>";
      if ($_GET['delete'] == 'success') {
        echo "delete success";
      } else if ($_GET['delete'] == 'error') {
        echo "an error occurred while deleting";
      }
      echo "<br><br><a href='index.php'><input type='button' value='Torna alla home'></a>";
      echo "</div>";
    } else {
      echo "<div style='width: 100%; text-align: center; margin-top: 20px'>";
      echo "<p>Image not found</p>";
      echo "</div>";
    }
  }
  ?>
  <br><br>
  <div class="clearfix"></div>
  <script src="assets/js/setlikevalue.js"></script>

<?php
  require "options/footer.opt.php";
} else {
  header("Location: portfolio.php");
}
