<?php
require_once 'includes/header.php';
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="section-title mb-3">Get in Touch</h2>
        <p class="lead text-white-50">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
    </div>
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="bg-dark border-secondary shadow-lg h-100 no-hover">
                <div class="card-body p-4 p-md-5">
                    <h4 class="text-white mb-4">Send us a Message</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-white-50 mb-2">Your Name</label>
                                    <input type="text" class="form-control bg-white text-dark border-secondary" id="name" placeholder="Enter Your Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white-50 mb-2">Your Email</label>
                                    <input type="email" class="form-control bg-white text-dark border-secondary" id="email" placeholder="name@example.com">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="subject" class="form-label text-white-50 mb-2">Subject</label>
                                    <input type="text" class="form-control bg-white text-dark border-secondary" id="subject" placeholder="Enter a Subject">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="message" class="form-label text-white-50 mb-2">Message</label>
                                    <textarea class="form-control bg-white text-dark border-secondary" placeholder="Leave a comment here" id="message" style="height: 150px"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn auth-btn w-100 py-2">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="col-lg-5">
            <div class="bg-dark text-white shadow-lg h-100 border-0 no-hover">
                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="mb-4">Contact Information</h4>
                        <p class="mb-5 text-white-50">Have a question or just want to say hi? We'd love to hear from you.</p>
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Address</h6>
                                <p class="mb-0 text-white-50">789 Studio Lane, Filmville,<br>Hollywood - 90210</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3">
                                <i class="fas fa-phone-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Phone</h6>
                                <p class="mb-0 text-white-50">+91 9876543210</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle me-3">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="mb-0 text-white-50">movieflix@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h5 class="mb-3">Follow Us</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-danger rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="btn btn-outline-danger rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-danger rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-outline-danger rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>