@extends('user.layouts.master')

@section('content')
        <!-- Contact Start -->
        <div class="container-fluid">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact Us</span></h2>
            <div class="row px-xl-5">
                <div class="col-lg-7 mb-5">
                    <div class="contact-form bg-light p-30">
                        <div id="success"></div>
                        <form name="sentMessage" action="{{ route('user.saveContact') }}" method="POST" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Your Name"
                                   required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                                @error('name')
                                <div class="invalid-feedback mb-3">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Email"
                                  required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                                @error('email')
                                <div class="invalid-feedback mb-3">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="control-group">
                                <textarea class="form-control @error('message') is-invalid @enderror" rows="8" name="message" placeholder="Message"
                                    required="required"
                                    data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                                @error('message')
                                <div class="invalid-feedback mb-3">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div>
                                <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Send
                                    Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 mb-5">
                    <div class="bg-light p-30 mb-30">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d488799.4874326692!2d95.90137815046135!3d16.8389524908704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1949e223e196b%3A0x56fbd271f8080bb4!2sYangon%2C%20Myanmar%20(Burma)!5e0!3m2!1sen!2ssg!4v1667386643077!5m2!1sen!2ssg"
                        width="500" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="bg-light p-30 mb-3">
                        <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, Yangon, Myanmar>
                        <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                        <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
@endsection
