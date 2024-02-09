<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/coursepage.css">
    <title>Course Details</title>
</head>

<body>
    <header id="schoolify-header">
        <nav>
            <input type="checkbox" id="check" style="color: transparent">
            <label for="check" class="checkbtn">
                <div class="hamber">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </label>
            <label class="logo">Schoolify</label>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">LOGIN</a></li>
            </ul>
        </nav>
        <section></section>
    </header>
    <!-- Course Page -->
    <!-- Top Section -->
    <div class="Image-and-card">
        <div class="image-with-text">
            <div class="overlay"></div>
            <img src="./images/web_app.jpg" alt="University Image">

            <div class="image-text-container">
                <h1 class="image-text">Web Development</h1>
                <p>Master modern web technologies and frameworks, crafting dynamic web applications to meet today's
                    digital demands. Empower yourself to shape the future of the internet with innovative and responsive
                    solutions.</p>
<!--                <a href="registration.php" class="register-button">Register</a>-->
            </div>
        </div>

        <div class="course_detail_card">
            <div class="details">
                <div class="detail-item">
                    <h3><strong>Credit Hours</strong></h3>
                    <p>3 credit hours</p>
                </div>
                <hr>
                <div class="detail-item">
                    <h3><strong>Class Duration</strong></h3>
                    <p>1.5 Hours</p>
                </div>
                <hr>
                <div class="detail-item">
                    <h3><strong>Class per week</strong></h3>
                    <p>2 Classes</p>
                </div>
            </div>
        </div>

    </div>
    <div class="about">
        <h1>Description</h1>

        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
            industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
            scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
            electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of
            Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like
            Aldus PageMaker including versions of Lorem Ipsum.

          
        </p>
        <p>
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
        </p>

    </div>

    <div class="outline">
        <div>
            <h1>Course Outline</h1>
        </div>
        <div class="outline-cards">
            <div class="outline_card">
                <div class="course_modules">
                    <h3>Introduction to Web Development</h3>
                    <ul>
                        <li>Understanding the World Wide Web</li>
                        <li>Client-Side vs. Server-Side Development</li>
                        <li>Essential Web Development Tools</li>
                    </ul>
                </div>
                <div class="course_modules">
                    <h3>HTML (Hypertext Markup Language)</h3>
                    <ul>
                        <li>HTML Structure and Syntax</li>
                        <li>Creating Web Pages with HTML</li>
                        <li>HTML5 Features and Semantic Elements</li>
                        <li>Forms and Input Elements</li>
                    </ul>
                </div>
            </div>

            <div class="outline_card">
                <div class="course_modules">
                    <h3>Back-End Development</h3>
                    <ul>
                        <li>Introduction to server-side programming.
                        <li>Building databases with SQL and NoSQL.</li>
                        <li>Creating server applications with Node.js and Express.</li>
                        <li>Implementing user authentication and authorization.</li>
                    </ul>
                </div>
                <div class="course_modules">
                    <h3>Full-Stack Development</h3>
                    <ul>
                        <li>Combining front-end and back-end skills to create full-stack applications.
                        <li>RESTful API development.</li>
                        <li>Integrating third-party APIs.</li>
                        <li>Deploying web applications to hosting services.</li>
                    </ul>
                </div>
            </div>

            <div class="outline_card">
                <div class="course_modules">
                    <h3>Web Security</h3>
                    <ul>
                        <li>Understanding common web security threats.
                        <li>Implementing best practices for secure web development.</li>
                        <li>Protecting user data and privacy.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="content">
            <div class="left-box">
                <label for="logo" class="logo">Schoolify</label>
            </div>
            <div class="right-box">Contact Us
                <ul>
                    <li>Email:something@something.com</li>
                    <li>Tel No.:+34-354343</li>
                </ul>
            </div>
        </div>
        <hr class="Break">
        <br>
        <div class="middle-box">
            <ul>
                <li><a class="active" href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <br>
        <div class="bottom">
            <p>Copyright © Schoolify Inc., All rights reserved.</p>
        </div>
        </div>

    </footer>
</body>

</html>