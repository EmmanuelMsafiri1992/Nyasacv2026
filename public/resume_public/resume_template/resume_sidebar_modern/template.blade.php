<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('resume_public/resume_template/resume_sidebar_modern/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="rb-layout">
        <div class="resume-container">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <h1 class="name-title"><span id="cv-name">Your Name</span></h1>
                    <h2 class="job-title"><span id="cv-job-position">Job Title</span></h2>
                </div>

                <!-- Contact Section -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Contact</h3>
                    <div class="contact-list">
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

                <!-- Skills Section -->
                <div class="sidebar-section" id="cv-skill-info">
                    <h3 class="sidebar-title">Skills</h3>
                    <div class="skills-list">
                        <div class="skill-item" id="cv-skill">
                            <div class="skill-name"><span id="cv-skill-name">Skill Name</span></div>
                            <div class="skill-progress">
                                <div class="skill-progress-bar" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Section -->
                <div class="sidebar-section" id="cv-additional-info">
                    <h3 class="sidebar-title">Additional Info</h3>
                    <div class="sidebar-content">
                        <p><span id="cv-additional">Additional information...</span></p>
                    </div>
                </div>

            </aside>

            <!-- Main Content -->
            <main class="main-content">

                <!-- Target/Objective Section -->
                <div class="section" id="cv-target-info">
                    <h3 class="section-title">Professional Summary</h3>
                    <div class="section-content">
                        <p><span id="cv-target">Your professional summary goes here...</span></p>
                    </div>
                </div>

                <!-- Experience Section -->
                <div class="section" id="cv-exp-info">
                    <h3 class="section-title">Experience</h3>
                    <div class="section-content">
                        <div class="content-item" id="cv-exp">
                            <div class="item-header">
                                <div>
                                    <h4><span id="cv-exp-pos">Position</span></h4>
                                    <div class="item-company"><span id="cv-exp-company">Company Name</span></div>
                                </div>
                                <div class="item-date"><span id="cv-exp-time">Time Period</span></div>
                            </div>
                            <p><span id="cv-exp-content">Description of responsibilities and achievements...</span></p>
                        </div>
                    </div>
                </div>

                <!-- Education Section -->
                <div class="section" id="cv-edu-info">
                    <h3 class="section-title">Education</h3>
                    <div class="section-content">
                        <div class="content-item" id="cv-edu">
                            <div class="item-header">
                                <div>
                                    <h4><span id="cv-edu-major">Degree / Major</span></h4>
                                    <div class="item-company"><span id="cv-edu-school">School Name</span></div>
                                </div>
                                <div class="item-date"><span id="cv-edu-time">Time Period</span></div>
                            </div>
                            <p><span id="cv-edu-content">Additional details about education...</span></p>
                        </div>
                    </div>
                </div>

                <!-- Activities Section -->
                <div class="section" id="cv-act-info">
                    <h3 class="section-title">Activities & Involvement</h3>
                    <div class="section-content">
                        <div class="content-item" id="cv-act">
                            <div class="item-header">
                                <div>
                                    <h4><span id="cv-act-name">Activity Name</span></h4>
                                </div>
                                <div class="item-date"><span id="cv-act-time">Time Period</span></div>
                            </div>
                            <p><span id="cv-act-content">Description of activities...</span></p>
                        </div>
                    </div>
                </div>

                <!-- Awards Section -->
                <div class="section" id="cv-award-info">
                    <h3 class="section-title">Awards & Achievements</h3>
                    <div class="section-content">
                        <div class="award-item" id="cv-award">
                            <div class="award-header">
                                <h4><span id="cv-award-name">Award Name</span></h4>
                                <span class="award-year"><span id="cv-award-time">Year</span></span>
                            </div>
                            <p><span id="cv-award-content">Award description...</span></p>
                        </div>
                    </div>
                </div>

                <!-- References Section -->
                <div class="section" id="cv-ref-info">
                    <h3 class="section-title">References</h3>
                    <div class="section-content">
                        <div class="reference-item" id="cv-ref">
                            <h4><span id="cv-ref-name">Reference Name</span></h4>
                            <div class="ref-info">
                                <div><span id="cv-ref-job">Job Title</span> at <span id="cv-ref-company">Company Name</span></div>
                                <div class="ref-contact">
                                    <span><i class="fas fa-phone"></i> <span id="cv-ref-phone">Phone</span></span>
                                    <span><i class="fas fa-envelope"></i> <span id="cv-ref-email">Email</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
