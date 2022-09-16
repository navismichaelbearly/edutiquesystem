<?php
session_start(); /*Session Start*/
ini_set('display_errors', 1);
/* Checks if user is logged in to the system if not then it will be redirected to login page - security */
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

date_default_timezone_set('Asia/Singapore');

/* include files */
require_once "inc/config.php";
include "inc/constants.php";
include 'inc/functions.php';
$article_title = $mag_id = $essay_type_id2 = $article_path = $article_image = $article_content = $audio_path = $art_year = $theme = $genre = $topic_words = $audio_support = $fiction = $difficulty_level = $description = $word_count = $author = $issue_no = $article_id = $mag_issue_type2 = $path3 = '';

$stmt = $mysqli->prepare("SELECT article_title,mag_id,a.essay_type_id,article_path,article_image,article_content,audio_path,art_year,theme,genre,topic_words,audio_support ,fiction,difficulty_level,description,word_count ,author,issue_no,article_id, b.essay_type from edu_article_dummy a inner join edu_essay_type b on a.essay_type_id=b.essay_type_id where article_id =?");

$stmt->bind_param("s", $param_user_id);
// Set parameters 
$param_user_id = $_REQUEST['actID'];
$stmt->execute();
$stmt->bind_result($article_title, $mag_id, $essay_type_id2, $article_path, $article_image, $article_content, $audio_path, $art_year, $theme, $genre, $topic_words, $audio_support, $fiction, $difficulty_level, $description, $word_count, $author, $issue_no, $article_id, $essay_type2);
$stmt->fetch();
$stmt->close();


$stmt = $mysqli->prepare("SELECT mag_type_id from edu_magazine  where mag_id =?");
/* Bind parameters */
$stmt->bind_param("s", $param_mag_id);
// Set parameters 
$param_mag_id = $mag_id;
$stmt->execute();
$stmt->bind_result($mag_type_id2);
$stmt->fetch();
$stmt->close();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Edutique System</title>

  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="css/metisMenu.min.css" rel="stylesheet">

  <!-- Timeline CSS -->
  <link href="css/timeline.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/startmin.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="css/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <style>
    .inp {
      border: none;
      border-bottom: 1px solid #000000;
      padding: 5px 10px;
      outline: none;
    }

    [placeholder]:focus::-webkit-input-placeholder {
      transition: text-indent 0.4s 0.4s ease;
      text-indent: -100%;
      opacity: 1;
    }


    select {
      font-family: 'Poppins' !important;
      color: #0F96E8;
      background: #fff;
      border: none;
    }

    .selectheadback {
      background-color: transparent;
      font-family: 'Poppins' !important;
    }

    .audioshow {
      display: none;
    }

    .btn-success[disabled] {
      background-color: #d0d0d4;
      border-color: #c0c0c2;
    }

    .centerIMG {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }


    /* if screen width below 1300 px,  */
    @media screen and (max-width: 1300px) {
      .scrambleinput{
        max-width: 180px;
      }
    }
  </style>

  <script src="ckeditor/ckeditor.js"></script>
</head>

<body>

  <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar-inverse navbar-fixed-top" role="navigation">

      <!-- toggle menu in mobile and tablet view -->
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>


      <!-- /.navbar-top-links -->

      <?php include 'inc/sidebar.php'; ?>
    </nav>

    <div id="page-wrapper">
      <div class="row">
        <?php include 'inc/gsearch.php'; ?>
        <!-- /.col-lg-12 -->
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h3 id="grid-responsive-resets" class="headertext">Add Activity</h3>
            <br>


            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="Myform">
              <fieldset>
                <div class="row">
                  <div class="col-lg-4">
                    <label>Title</label>
                    <div class="form-group">
                      <input class="form-control formfield" placeholder="Title" name="title" id="title" type="text" required value="<?php echo $article_title; ?>">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Type of Activity</label>
                    <div class="form-group">
                      <span>
                        <select name="activity_type_id" id="activity_type_id" class="form-control formfield selectheadback">

                          <?php
                          if ($stmt = $mysqli->prepare("SELECT activity_type_id,activity_type FROM edu_activity_type where activity_type_status=?")) {

                            $stmt->bind_param("s", $param_status);
                            // Set parameters 
                            $param_status = $active;

                            $stmt->execute();
                            /* bind variables to prepared statement */
                            $stmt->bind_result($mag_type_id, $mag_type);
                            $sr = 1;
                            /* fetch values */
                            echo " <option >Select Type of Activity</option>";
                            while ($stmt->fetch()) {
                              echo " <option   value='" . $mag_type_id . "' " . (($mag_type_id == $mag_type_id2) ? 'selected="selected"' : "") . ">" . $mag_type . "</option>";
                            }
                          }
                          ?>
                        </select>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Type of Publication</label>
                    <div class="form-group">
                      <span>
                        <select name="mag_type" id="mag_type" class="form-control formfield selectheadback">

                          <?php
                          if ($stmt = $mysqli->prepare("SELECT mag_type_id,mag_type FROM edu_mag_type where mag_type_status=?")) {

                            $stmt->bind_param("s", $param_status);
                            // Set parameters 
                            $param_status = $active;


                            $stmt->execute();
                            /* bind variables to prepared statement */
                            $stmt->bind_result($mag_type_id, $mag_type);
                            $sr = 1;
                            /* fetch values */
                            echo " <option >Select Type of Publication</option>";
                            while ($stmt->fetch()) {

                              echo " <option   value='" . $mag_type_id . "' " . (($mag_type_id == $mag_type_id2) ? 'selected="selected"' : "") . ">" . $mag_type . "</option>";
                            }
                          }
                          ?>
                        </select>

                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Upload Activity Image (200 X 265 PX)</label>
                    <div class="form-group">
                      <span>
                        <input type="file" name="file" id="file" value="Upload" />
                        <?php if ($article_image != '') { ?> <img src='<?php echo $article_image; ?>' width="50" height="50"><?php } ?>
                      </span>
                    </div>
                  </div>
                </div>
                <label>Content</label>
                <div class="form-group">
                  <textarea name="content" id="content" class="form-control  py-2" rows="10" placeholder="Content" required><?php echo $article_content; ?></textarea>
                  <script>
                    var editor = CKEDITOR.replace('content', {
                      filebrowserUploadUrl: 'ckeditor/ck_upload.php',
                      filebrowserUploadMethod: 'form',
                      height: 350
                    });
                  </script>
                </div>


                <div class="row">
                  <div class="col-lg-4">
                    <label>Year</label>
                    <div class="form-group">
                      <span>
                        <input type="date" id="act_year" name="act_year" class="form-control formfield" value="<?php if ($act_year != '') {
                                                                                                                  echo $newDate = date("Y-m-d", strtotime($art_year));
                                                                                                                } else {
                                                                                                                }  ?>" />

                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Select Article</label>
                    <div class="form-group">
                      <span>
                        <?php
                        $stmt = $mysqli->prepare("SELECT article_id, article_title FROM edu_article where article_status=?");
                        /* Bind parameters */
                        $stmt->bind_param("s", $param_status);
                        /* Set parameters */

                        $param_status = $active;
                        $stmt->execute();
                        $stmt->bind_result($essay_type_id, $essay_type);
                        $sr = 1;
                        echo "<input list='texttype' id='_type' name='article_id' class='form-control formfield' required value='" . $essay_type2 . "' /></label>";
                        echo "<datalist id='texttype'>";
                        while ($stmt->fetch()) {
                          echo "<option style='font-family: Poppins !important;' value='" . $essay_type . "' " . (($essay_type == $essay_type2) ? 'selected="selected"' : "") . ">" . $essay_type . "</option>";
                          $sr++;
                        }
                        echo "</datalist>"; ?>

                      </span>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <label>Issue No.</label>
                    <div class="form-group">
                      <span id="dataIssueno">
                        <input id='issue_no' name='issue_no' class="form-control formfield" type="text" value="<?php echo $issue_no; ?>">
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Theme</label>
                    <div class="form-group">
                      <input class="form-control formfield" placeholder="Theme" name="theme" id="theme" type="text" value="<?php echo $theme; ?>">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Keywords</label>
                    <div class="form-group">
                      <input class="form-control formfield" placeholder="Keywords" name="topic_words" id="topic_words" type="text" value="<?php echo $topic_words; ?>">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <label>Fiction/Non-Fiction</label>
                    <div class="form-group">
                      <span>

                        <select id='fiction' class='form-control formfield selectheadback' name='fiction'>
                          <option value='Fiction' <?php if ($fiction == 'Fiction') {
                                                    echo 'selected';
                                                  } ?>>Fiction</option>
                          <option value='Non-Fiction' <?php if ($fiction == 'Non-Fiction') {
                                                        echo 'selected';
                                                      } ?>>Non-Fiction</option>

                        </select>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Level of Difficulty</label>
                    <div class="form-group">
                      <span>
                        <select id='difficulty_level' class='form-control formfield selectheadback' name='difficulty_level'>
                          <option value='Lower Elementary' <?php if ($difficulty_level == 'Lower Elementary') {
                                                              echo 'selected';
                                                            } ?>>Lower Elementary</option>
                          <option value='Upper Elementary' <?php if ($difficulty_level == 'Upper Elementary') {
                                                              echo 'selected';
                                                            } ?>>Upper Elementary</option>
                          <option value='Lower Intermediate' <?php if ($difficulty_level == 'Lower Intermediate') {
                                                                echo 'selected';
                                                              } ?>>Lower Intermediate</option>
                          <option value='Upper Intermediate' <?php if ($difficulty_level == 'Upper Intermediate') {
                                                                echo 'selected';
                                                              } ?>>Upper Intermediate</option>
                          <option value='Lower Advanced' <?php if ($difficulty_level == 'Lower Advanced') {
                                                            echo 'selected';
                                                          } ?>>Lower Advanced</option>
                          <option value='Upper Advanced' <?php if ($difficulty_level == 'Upper Advanced') {
                                                            echo 'selected';
                                                          } ?>>Upper Advanced</option>
                        </select>
                      </span>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <label>Word Count</label>
                    <div class="form-group">
                      <span>
                        <input class="form-control formfield" placeholder="Word Count" name="word_count" id="word_count" type="text" value="<?php echo $word_count; ?>">
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>Author</label>
                    <div class="form-group">
                      <span>

                        <input class="form-control formfield" placeholder="Author" name="author" id="author" type="text" value="<?php echo $author; ?>">
                      </span>
                    </div>
                  </div>


                  <div class="col-lg-4">
                    <label>Quick Tips</label>
                    <div class="form-group">
                      <span>

                        <textarea name="quick_tips" id="quick_tips" class="form-control  py-2" rows="2" placeholder="Quick Tips for Activity"><?php echo $description; ?></textarea>
                      </span>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <label>Audio Support</label>
                    <div class="form-group">
                      <span>

                        <select id='audio_support' class='form-control formfield selectheadback' name='audio_support'>
                          <option>Select</option>
                          <option value='Yes' <?php if ($audio_support == 'Yes') {
                                                echo 'selected';
                                              } ?>>Yes</option>
                          <!--<option  value='Yes (2 audios in 1 article)' <?php #if($audio_support=='Yes (2 audios in 1 article)'){ echo 'selected'; }
                                                                            ?>>Yes (2 audios in 1 article)</option>-->
                          <option value='No' <?php if ($audio_support == 'No') {
                                                echo 'selected';
                                              } ?>>No</option>
                        </select>
                      </span>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div <?php if ($_REQUEST['actID'] == 0) { ?> class="audioshow" <?php } ?> id="audioshow">
                      <label>Upload Audio </label>
                      <div class="form-group">
                        <span>
                          <input type="file" name="file_audio" id="file_audio" value="Upload" multiple="multiple" />
                          <?php


                          $stmt = $mysqli->prepare("SELECT path FROM edu_article_audio_dummy where article_id=?");
                          /* Bind parameters */
                          $stmt->bind_param("s", $param_article_id);
                          /* Set parameters */

                          $param_article_id = $_REQUEST['actID'];
                          $stmt->execute();
                          $stmt->bind_result($path);

                          // fetch values 
                          while ($stmt->fetch()) {
                            $path1 = substr($path, strpos($path, "/") + 1);
                            $path2 = substr($path1, strpos($path1, "/") + 1);
                            $path3 = substr($path2, strpos($path2, "/") + 1);
                            echo "<span>" . $path3 . "</span><br>";
                          }


                          ?>

                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="activity_html" id="activity_html" value="">
                <input type="hidden" name="activity_result" id="activity_result" value="[]">



                <div class="row">


                  <hr>
                  <div class="col-lg-12 activity" id='unscramble'>
                    <label>Language Game - Unscramble</label>
                    <div class="">

                      <span class="btn btn-lg btn-success btn-block formfield" style="margin: 20px;" data-counter='0' id="add_scramble">Click to Add more Fields</span>

                      <div class="row" id='scramble_block' style='padding-bottom:20px;'>


                      </div>
                      <div class="row container" id="disp_scram" style="display: none;">


                      </div>


                    </div>
                  </div>
                  <hr>

                  <div class="col-lg-4">

                    <div class="form-group">
                      <span>
                        <input type="submit" class="btn btn-lg btn-success btn-block formfield" value="Save to Draft" id="savedraft" <?php if ($_REQUEST['actID'] > 0) {
                                                                                                                                        echo "disabled";
                                                                                                                                      } ?>>

                      </span>
                    </div>
                  </div>

                  <div class="col-lg-4">

                    <div class="form-group">
                      <span>
                        <input type="submit" name="subForm" class="btn btn-lg btn-success btn-block formfield" value="Publish" id="upload_content">

                      </span>
                    </div>
                  </div>

                </div>
              </fieldset>
            </form>

          </div>
          <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->
  <!-- Modal popup form for success -->
  <div class="modal fade" id="successAll" role="dialog" align="center">
    <div class="modal-dialog" style="margin-top:150px;">

      <!-- Modal content-->
      <div class="modal-content1">

        <div class="modal-body1">

          <img src="images/tick-icon.png" width="100" height="100" style="width:100px; height:100px;">
        </div>
      </div>

    </div>
  </div>

  <!-- upload audio completion bar --------------->
  <div class="modal fade" id="successUpload" role="dialog" align="center">
    <div class="modal-dialog" style="margin-top:150px;">

      <!-- Modal content-->
      <div class="modal-content1">

        <div class="modal-body1">

          <img src='images/giphy.gif'>
        </div>
      </div>

    </div>
  </div>

  <!-- jQuery -->
  <script src="js/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="js/metisMenu.min.js"></script>

  <!-- Custom Theme JavaScript -->
  <script src="js/startmin.js"></script>
  <script>
    $(document).ready(function() {
      $("#file").change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var match = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))) {
          alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
          $("#file").val('');
          return false;
        }
      });

      $("#file_audio").change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var match = ['audio/mpeg', 'audio/mp3', 'audio/mpeg'];
        if (!((fileType == match[0]))) {
          alert('Sorry, only MP3 file is allowed to upload.');
          $("#file_audio").val('');
          return false;
        }
      });

      $('#upload_content ').on('click', function(e) {
        //do button 1 thing


        $('#Myform ').on('submit', function(e) {
          e.preventDefault();
          var data = new FormData(this);

          var imgData = document.getElementById('file_audio');

          for (var i = 0; i < imgData.files.length; i++) {
            data.append('my_file[]', imgData.files[i], imgData.files[i].name);
          }
          //add the content
          data.append('content', CKEDITOR.instances['content'].getData());
          data.append('imagPATH', '<?php echo $article_image; ?>');
          data.append('dummyActid', '<?php echo $article_id; ?>');
          data.append('dummyPath', '<?php echo $path3; ?>');
          $.ajax({
            type: 'POST',
            url: 'data/uploadActimg.php',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function() {
              $('#successUpload').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
              });
            },
            success: function(data) { //console.log(response);
              console.log(data);
              $('#successUpload').modal('hide');
              $('#successAll').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
              });
              $('#Myform')[0].reset();
              setTimeout(function() {
                $('#successAll').modal('hide');
              }, 2000);
              setTimeout(function() {
                window.location = 'activities.php';
              }, 2000);
            }
          });

        });

      });

      $('#savedraft').on('click', function(e) {
        //do button 1 thing


        $('#Myform ').on('submit', function(e) {
          e.preventDefault();
          var data = new FormData(this);
          //add the content
          var imgData = document.getElementById('file_audio');

          for (var i = 0; i < imgData.files.length; i++) {
            data.append('my_file[]', imgData.files[i], imgData.files[i].name);
          }
          data.append('content', CKEDITOR.instances['content'].getData());
          $.ajax({
            type: 'POST',
            url: 'data/saveTodarftactivity.php',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function() {
              $('#successUpload').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
              });
            },
            success: function(data) {
              console.log(data)
              $('#successUpload').modal('hide');
              $('#successAll').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
              });
              $('#Myform')[0].reset();
              setTimeout(function() {
                $('#successAll').modal('hide');
              }, 2000);
              setTimeout(function() {
                window.location = 'activity-draft.php';
              }, 2000);
            }
          });

        });
      });

      $('#mag_type').on('change', function() {

        var mag_type_var = $("#mag_type").val();
        $.ajax({
          type: 'POST',
          url: 'data/getIssuenoinfo.php',
          data: {
            mag_type_var: mag_type_var
          },
          cache: false,
          success: function(data) {
            $("#dataIssueno").html(data);
          }
        });
        event.preventDefault();
      });

      $('#audio_support').on('change', function() {

        var audio_support_var = $("#audio_support").val();
        if (audio_support_var == "Yes") {

          $("#audioshow").removeClass("audioshow");
        } else {
          $("#audioshow").addClass("audioshow");
        }
      });

    });

    $(document).ready(function() {
      // Hide all divs with class activity
      $(".activity").hide();

      // when input with id activity_type_id is changed
      $("#activity_type_id").change(function() {

        if ($("#activity_type_id").val() == "8") {
          $("#unscramble").show();
        } else {
          $("#unscramble").hide();
        }
      });

      // when button with id add_scramble is clicked (add more scramble)
      $("#add_scramble").click(function() {
        // get data-span value of the button
        var span_value = $(this).attr("data-counter");
        // increment it and add to the button
        span_value++;
        $(this).attr("data-counter", span_value);
        var html = `<div class= "col-md-4" style="padding-bottom:15px;">   
              <input class="form-control scrambleinput" placeholder="Scrambled Word" style="margin: 10px 0px;" name="sc` + span_value + `" id="sc` + span_value + `" type="text" value="">
              <input class="form-control scrambleinput" placeholder="Correct Answer" name="ans` + span_value + `" id="ans` + span_value + `" type="text" value="">
            </div>`;
        $("#scramble_block").append(html);

        var arr1 = [],
          arr2 = [],
          activity_html = "";
        $("#disp_scram").html("");

        for (var i = 1; i <= span_value; i++) {
          var val = $("#sc" + i).val();
          var val1 = $("#ans" + i).val();
          arr1.push(val);
          arr2.push(val1);
          if (val != "" && val1 != "") {
            $("#disp_scram").append(`Scrambled: ` + val + ` &nbsp &nbsp <input class="formfield inp" name="sc` + i + `" id="sc` + i + `" data-answer="` + val1 + `"> `);
            activity_html += `<div class="row"><div class="col-md-2 align-middle">Scrambled: ` + val + `  &nbsp &nbsp </div><div class="col-md-2"><input class="inp" name="sc` + i + `" id="sc` + i + `" data-answer="` + val1 + `"> <br></div></div> `;
          }
        }

        // set value activity_html to input with id = activity_html
        $("#activity_html").val(activity_html);
        $("#activity_result").val(JSON.stringify(arr2));

        $("input").on("input", function() {
          if ($(this).hasClass("scrambleinput")) {
            var span_value = $('#add_scramble').attr("data-counter");

            var arr1 = [],
              arr2 = [],
              activity_html = "";
            $("#disp_scram").html("");

            for (var i = 1; i <= span_value; i++) {
              var val = $("#sc" + i).val();
              var val1 = $("#ans" + i).val();

              if (val != "" && val1 != "") {
                arr1.push(val);
                arr2.push(val1);
                $("#disp_scram").append(`Scrambled: ` + val + ` &nbsp &nbsp <input class="formfield inp" name="sc` + i + `" id="sc` + i + `" data-answer="` + val1 + `"> `);
                activity_html += `
                <div class="row"><div class="col-md-2 align-middle">Scrambled: ` + val + `  &nbsp &nbsp </div><div class="col-md-2"><input class="inp" name="sc` + i + `" id="sc` + i + `" data-answer="` + val1 + `"> <br></div></div>
                `;
              }
            }

            // set value activity_html to input with id = activity_html
            $("#activity_html").val(activity_html);
            $("#activity_result").val(JSON.stringify(arr2));
          }
        });
      });
    });
  </script>
</body>

</html>