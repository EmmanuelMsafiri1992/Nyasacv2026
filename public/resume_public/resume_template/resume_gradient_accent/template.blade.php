<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('resume_public/resume_template/resume_gradient_accent/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="rb-layout">
        <div id="rb-main">
            <!-- Header Section -->
            <div class="header-section">
                <div class="gradient-accent"></div>
                <h1 class="name-title"><span id="cv-name">Your Name</span></h1>
                <h2 class="job-title"><span id="cv-job-position">Job Title</span></h2>
            </div>

            <!-- Contact Section -->
            <div class="contact-section">
                <div class="contact-grid">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span id="cv-addr">Address</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span id="cv-phone">Phone</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span id="cv-email">Email</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <span id="cv-website">Website</span>
                    </div>
                </div>
            </div>

            <!-- Target/Objective Section -->
            <div class="section" id="cv-target-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-bullseye"></i></span>
                    Professional Summary
                </h3>
                <div class="section-content">
                    <p><span id="cv-target">Your professional summary goes here...</span></p>
                </div>
            </div>

            <!-- Experience Section -->
            <div class="section" id="cv-exp-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-briefcase"></i></span>
                    Experience
                </h3>
                <div class="section-content">
                    <div class="exp-item" id="cv-exp">
                        <div class="exp-header">
                            <div class="exp-left">
                                <h4><span id="cv-exp-pos">Position</span></h4>
                                <div class="exp-company"><span id="cv-exp-company">Company Name</span></div>
                            </div>
                            <div class="exp-right">
                                <span class="time-badge"><span id="cv-exp-time">Time Period</span></span>
                            </div>
                        </div>
                        <p><span id="cv-exp-content">Description of responsibilities and achievements...</span></p>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="section" id="cv-edu-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-graduation-cap"></i></span>
                    Education
                </h3>
                <div class="section-content">
                    <div class="exp-item" id="cv-edu">
                        <div class="exp-header">
                            <div class="exp-left">
                                <h4><span id="cv-edu-major">Degree / Major</span></h4>
                                <div class="exp-company"><span id="cv-edu-school">School Name</span></div>
                            </div>
                            <div class="exp-right">
                                <span class="time-badge"><span id="cv-edu-time">Time Period</span></span>
                            </div>
                        </div>
                        <p><span id="cv-edu-content">Additional details about education...</span></p>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="section" id="cv-skill-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-chart-bar"></i></span>
                    Skills
                </h3>
                <div class="section-content">
                    <div class="skills-container">
                        <div class="skill-item" id="cv-skill">
                            <div class="skill-header">
                                <span class="skill-name"><span id="cv-skill-name">Skill Name</span></span>
                            </div>
                            <div class="skill-bar-container">
                                <div class="skill-bar" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activities Section -->
            <div class="section" id="cv-act-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-users"></i></span>
                    Activities & Involvement
                </h3>
                <div class="section-content">
                    <div class="exp-item" id="cv-act">
                        <div class="exp-header">
                            <div class="exp-left">
                                <h4><span id="cv-act-name">Activity Name</span></h4>
                            </div>
                            <div class="exp-right">
                                <span class="time-badge"><span id="cv-act-time">Time Period</span></span>
                            </div>
                        </div>
                        <p><span id="cv-act-content">Description of activities...</span></p>
                    </div>
                </div>
            </div>

            <!-- Awards Section -->
            <div class="section" id="cv-award-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-trophy"></i></span>
                    Awards & Achievements
                </h3>
                <div class="section-content">
                    <div class="award-item" id="cv-award">
                        <div class="award-header">
                            <strong><span id="cv-award-name">Award Name</span></strong>
                            <span class="award-year"><span id="cv-award-time">Year</span></span>
                        </div>
                        <p><span id="cv-award-content">Award description...</span></p>
                    </div>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="section" id="cv-additional-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-info-circle"></i></span>
                    Additional Information
                </h3>
                <div class="section-content">
                    <p><span id="cv-additional">Additional information goes here...</span></p>
                </div>
            </div>

            <!-- References Section -->
            <div class="section" id="cv-ref-info">
                <h3 class="section-title">
                    <span class="title-icon"><i class="fas fa-handshake"></i></span>
                    References
                </h3>
                <div class="section-content">
                    <div class="reference-card" id="cv-ref">
                        <h4><span id="cv-ref-name">Reference Name</span></h4>
                        <div class="ref-job"><span id="cv-ref-job">Job Title</span></div>
                        <div class="ref-company"><span id="cv-ref-company">Company Name</span></div>
                        <div class="ref-contact">
                            <span><i class="fas fa-phone"></i> <span id="cv-ref-phone">Phone</span></span>
                            <span><i class="fas fa-envelope"></i> <span id="cv-ref-email">Email</span></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
