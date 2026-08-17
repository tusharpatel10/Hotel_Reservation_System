<?php
ob_start();
$title = "Home | Hotel Reservation System";
include_once './components/header.php';
include_once 'connection.php';

// Clear the URL after redirect start
if (isset($_GET['bookingSuccess'])) {
   $_SESSION['flash'] = [
      'type' => 'success',
      'message' => $_GET['bookingSuccess']
   ];
   header('Location: index.php');
   exit;
}
if (isset($_GET['bookingError'])) {
   $_SESSION['flash'] = [
      'type' => 'error',
      'message' => $_GET['bookingError']
   ];
   header('Location: index.php');
   exit;
}
// Clear the URL after redirect end

?>
<?php if (isset($_SESSION['flash'])) {
   $type = $_SESSION['flash']['type'];
   $message = $_SESSION['flash']['message'];
   $icon = $type === 'success' ? 'check-circle-fill' : 'exclamation-trinagle-fill';
?>
   <div class="alert alert-<?= $type ?> alert-dismissible text-center fade show mt-3" id="alert" role="alert">
      <span><?= $message  ?></span>
   </div>
<?php
   unset($_SESSION['flash']);
} ?>
<script>
   const alert = document.getElementById("alert");
   alert.style.opacity = "1";
   alert.style.transition = "opacity 0.5s ease";

   // fade out after 2 seconds
   setTimeout(() => {
      alert.style.opacity = "0";

      // hide after the fade-out animation finished
      setTimeout(() => {
         alert.style.display = "none";
      }, 500);
   }, 4500);
</script>
<!-- banner -->
<section class="banner_main">
   <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
      <ol class="carousel-indicators">
         <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
         <li data-target="#myCarousel" data-slide-to="1"></li>
         <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
         <div class="carousel-item active">
            <img class="first-slide" src="assets/images/banner1.jpg" alt="First slide">
            <div class="container">
            </div>
         </div>
         <div class="carousel-item">
            <img class="second-slide" src="assets/images/banner2.jpg" alt="Second slide">
         </div>
         <div class="carousel-item">
            <img class="third-slide" src="assets/images/banner3.jpg" alt="Third slide">
         </div>
      </div>
      <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="sr-only">Next</span>
      </a>
   </div>
   <div class="booking_ocline">
      <div class="container">
         <div class="row">
            <div class="col-md-5">
               <div class="book_room">
                  <h1>Book a Room Online</h1>
                  <form class="book_now">
                     <div class="row">
                        <div class="col-md-12">
                           <span>Arrival</span>
                           <img class="date_cua" src="assets/images/date.png">
                           <input class="online_book" placeholder="dd/mm/yyyy" type="date" name="dd/mm/yyyy">
                        </div>
                        <div class="col-md-12">
                           <span>Departure</span>
                           <img class="date_cua" src="assets/images/date.png">
                           <input class="online_book" placeholder="dd/mm/yyyy" type="date" name="dd/mm/yyyy">
                        </div>
                        <div class="col-md-12">
                           <button class="book_btn">Book Now</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end banner -->
<!-- about -->
<div class="about">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-5">
            <div class="titlepage">
               <h2>About Us</h2>
               <p>The passage experienced a surge in popularity during the 1960s when Letraset used it on their
                  dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their
                  software. Today it's seen all around the web; on templates, websites, and stock designs. Use our
                  generator to get your own, or read on for the authoritative history of lorem ipsum. </p>
               <a class="read_more" href="Javascript:void(0)"> Read More</a>
            </div>
         </div>
         <div class="col-md-7">
            <div class="about_img">
               <figure><img src="assets/images/about.png" alt="#" /></figure>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end about -->
<!-- our_room -->
<div class="our_room">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Book Now</h2>
               <p>Comfortable and elegant rooms designed to make your stay relaxing and memorable. Enjoy modern amenities, a peaceful atmosphere, and everything you need for a comfortable stay.</p>
            </div>
         </div>
      </div>
      <div class="row">
         <?php
         // write Query start
         $showHotelData = "SELECT hotel.HotelName,hotel.HotelDescription,hotel.HotelImage,rooms.Room_id,rooms.Room_No,rooms.Floor_No,Rooms.NoOfPersons FROM hotel INNER JOIN rooms on hotel.hotel_id=rooms.hotel_id";
         $result = mysqli_query($conn, $showHotelData);
         if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
         ?>
               <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                  <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                     <!-- Room Image -->
                     <div class="position-relative">
                        <img
                           src="admin/images/hotel_rooms/<?php echo htmlspecialchars($row['HotelImage']); ?>"
                           class="card-img-top"
                           alt="<?php echo htmlspecialchars($row['HotelName']); ?>"
                           style="height: 230px; object-fit: cover;">
                     </div>

                     <!-- Room Details -->
                     <div class="card-body p-4">

                        <h4 class="card-title fw-bold mb-2">
                           <?php echo htmlspecialchars($row['HotelName']); ?>
                        </h4>

                        <p class="text-muted small mb-4">
                           <?php echo htmlspecialchars($row['HotelDescription']); ?>
                        </p>

                        <!-- Room Information -->
                        <div class="row g-3">

                           <div class="col-6">
                              <div class="bg-light rounded-3 p-3 text-center">
                                 <i class="bi bi-door-open text-primary fs-4"></i>
                                 <div class="small text-muted mt-1">Room No.</div>
                                 <strong>
                                    <?php echo htmlspecialchars($row['Room_No']); ?>
                                 </strong>
                              </div>
                           </div>

                           <div class="col-6">
                              <div class="bg-light rounded-3 p-3 text-center">
                                 <i class="bi bi-layers text-primary fs-4"></i>
                                 <div class="small text-muted mt-1">Floor</div>
                                 <strong>
                                    <?php echo htmlspecialchars($row['Floor_No']); ?>
                                 </strong>
                              </div>
                           </div>

                           <div class="col-12">
                              <div class="bg-light rounded-3 p-3 d-flex align-items-center">
                                 <i class="bi bi-people text-primary fs-4 me-3"></i>

                                 <div>
                                    <div class="small text-muted">Guests</div>
                                    <strong>
                                       <?php echo htmlspecialchars($row['NoOfPersons']); ?>
                                       Persons
                                    </strong>
                                 </div>
                              </div>

                              <?php
                              if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['user_roles']) && $_SESSION['user_roles'] == 'Users') { ?>
                                 <a href="BookNow.php?bookingid=<?php echo $row['Room_id'] ?>"
                                    class="btn btn-primary w-60 rounded-3 py-1">
                                    Book Now
                                 </a>
                              <?php } else { ?>
                                 <a href="Login.php"
                                    class="btn btn-primary w-60 rounded-3 py-1">
                                    Book Now
                                 </a>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php }
         } else { ?>
            <div class="col-md-4 col-sm-6">
               <div id="serv_hover" class="room">
                  <div class="bed_room">
                     <h3>No Data Available</h3>
                     <p></p>
                  </div>
               </div>
            </div>
         <?php   } ?>
         <!-- <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
               <div class="room_img">
                  <figure><img src="assets/images/room2.jpg" alt="#" /></figure>
               </div>
               <div class="bed_room">
                  <h3>Bed Room</h3>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
               <div class="room_img">
                  <figure><img src="assets/images/room3.jpg" alt="#" /></figure>
               </div>
               <div class="bed_room">
                  <h3>Bed Room</h3>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
               <div class="room_img">
                  <figure><img src="assets/images/room4.jpg" alt="#" /></figure>
               </div>
               <div class="bed_room">
                  <h3>Bed Room</h3>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
               <div class="room_img">
                  <figure><img src="assets/images/room5.jpg" alt="#" /></figure>
               </div>
               <div class="bed_room">
                  <h3>Bed Room</h3>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
               </div>
            </div>
         </div>
         <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room">
               <div class="room_img">
                  <figure><img src="assets/images/room6.jpg" alt="#" /></figure>
               </div>
               <div class="bed_room">
                  <h3>Bed Room</h3>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
               </div>
            </div>
         </div> -->
      </div>
   </div>
</div>
<!-- end our_room -->
<!-- gallery -->
<div class="gallery">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>gallery</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery1.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery2.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery3.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery4.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery5.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery6.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery7.jpg" alt="#" /></figure>
            </div>
         </div>
         <div class="col-md-3 col-sm-6">
            <div class="gallery_img">
               <figure><img src="assets/images/gallery8.jpg" alt="#" /></figure>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end gallery -->
<!-- blog -->
<div class="blog">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Blog</h2>
               <p>Lorem Ipsum available, but the majority have suffered </p>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-4">
            <div class="blog_box">
               <div class="blog_img">
                  <figure><img src="assets/images/blog1.jpg" alt="#" /></figure>
               </div>
               <div class="blog_room">
                  <h3>Bed Room</h3>
                  <span>The standard chunk </span>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything
                     embarrassing hidden in the middle of text. All the Lorem Ipsum generatorsIf you are </p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="blog_box">
               <div class="blog_img">
                  <figure><img src="assets/images/blog2.jpg" alt="#" /></figure>
               </div>
               <div class="blog_room">
                  <h3>Bed Room</h3>
                  <span>The standard chunk </span>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything
                     embarrassing hidden in the middle of text. All the Lorem Ipsum generatorsIf you are </p>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="blog_box">
               <div class="blog_img">
                  <figure><img src="assets/images/blog3.jpg" alt="#" /></figure>
               </div>
               <div class="blog_room">
                  <h3>Bed Room</h3>
                  <span>The standard chunk </span>
                  <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything
                     embarrassing hidden in the middle of text. All the Lorem Ipsum generatorsIf you are </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end blog -->
<!--  contact -->
<div class="contact">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Contact Us</h2>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <form id="request" class="main_form">
               <div class="row">
                  <div class="col-md-12 ">
                     <input class="contactus" placeholder="Name" type="type" name="Name">
                  </div>
                  <div class="col-md-12">
                     <input class="contactus" placeholder="Email" type="type" name="Email">
                  </div>
                  <div class="col-md-12">
                     <input class="contactus" placeholder="Phone Number" type="type" name="Phone Number">
                  </div>
                  <div class="col-md-12">
                     <textarea class="textarea" placeholder="Message" type="type" Message="Name">Message</textarea>
                  </div>
                  <div class="col-md-12">
                     <button class="send_btn">Send</button>
                  </div>
               </div>
            </form>
         </div>
         <div class="col-md-6">
            <div class="map_main">
               <div class="map-responsive">
                  <iframe
                     src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Eiffel+Tower+Paris+France"
                     width="600" height="400" frameborder="0" style="border:0; width: 100%;"
                     allowfullscreen=""></iframe>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end contact -->

<?php
include_once './components/footer.php';
ob_end_flush();
?>