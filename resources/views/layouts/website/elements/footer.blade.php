<footer class="main-footer">
    <style>
        /* Style the scroll to top button */
        #scrollToTopBtn {
            position: fixed;
            bottom: 20px;
            right: 20px; /* Default position for larger screens */
            display: none; /* Hidden by default */
            background-color: #007bff;
            color: white;
            border: none;
            width: 50px; /* Fixed width */
            height: 50px; /* Fixed height */
            border-radius: 10%; /* Circular button */
            text-align: center;
            font-size: 15px; /* Font size for the icon */
            line-height: 50px; /* Center icon vertically */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
            transition: background-color 0.3s, transform 0.3s; /* Smooth transitions */
            z-index: 1000; /* Above other content */
        }
        #scrollToTopBtn:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Lift effect on hover */
        }
        
        /* Media query to change position on mobile */
        @media (max-width: 768px) {
            #scrollToTopBtn {
                right: 50%; /* Center horizontally */
                transform: translateX(50%); /* Adjust for centering */
                bottom: 20px; /* Keep the button above the bottom */
            }
        }
    </style>
    <!-- Scroll to Top Button -->
    <a id="scrollToTopBtn" href="">Top</a>

    <!-- JavaScript -->
    <script>
        // Get the button
        var mybutton = document.getElementById("scrollToTopBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        };

        // When the user clicks on the button, scroll to the top of the document
        mybutton.onclick = function(event) {
            event.preventDefault(); // Prevent default anchor link behavior (page refresh)
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
    </script>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 text-center text-lg-left">
                {!! website_footer() !!}
            </div>
            <div class="col-12 col-lg-2">
                <div class="float-lg-right text-center">
                    <style>
                        .visitor-counter span {
                            margin: 0 1px;
                            padding: 3px;
                            background-color: #333333;
                            color: #ffffff
                        }

                    </style>
                    {!! website_visitor() !!}
                </div>
            </div>
        </div>
    </div>
</footer>
