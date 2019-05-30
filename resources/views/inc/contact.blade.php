<section class="contact">
    <div class="container--contact">
        <div class="newsletter">
            <h5>Newsletter</h5>
            <p>Subscribe to our newsletter to get awesome artwork in your mailbox weekly.</p>
            <form class="newsletter-form" action="" method="get">
                
                @csrf
                <input class="searchbar--header subscribebar" type="text" name="email" placeholder="Email">
                <input class="btn-subscribe" type="submit" value="Subscribe">
            
            </form>
        </div>
        <div class="connect">
            <h5>Connect with us</h5>
            <ul class="list--contact py-3">
                <li><a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-square"></i></a></li>
                <li><a href="https://twitter.com" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter-square"></i></a></li>
                <li><a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="appstore">
            <h5>Mobile App</h5>
            <ul class="list--contact py-3">
                <li><a href="https://play.google.com/store?hl=en_US" target="_blank" rel="noopener noreferrer"><i class="fab fa-google-play"></i></a></li>
                <li><a href="https://www.apple.com/ios/app-store/" target="_blank" rel="noopener noreferrer"><i class="fab fa-apple"></i></a></li>
            </ul>
        </div>
    </div>
</section>