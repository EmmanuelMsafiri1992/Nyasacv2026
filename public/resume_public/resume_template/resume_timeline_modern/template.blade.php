<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('resume_public/resume_template/resume_timeline_modern/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="rb-layout">
        <div id="rb-main">
            <!-- Header Section -->
            <div class="header-section">
                <h1 class="name-title"><span id="cv-name">Your Name</span></h1>
                <h2 class="job-title"><span id="cv-job-position">Job Title</span></h2>
                <div class="contact-info">
                    <span><i class="fas fa-map-marker-alt"></i> <span id="cv-addr">Address</span></span>
                    <span><i class="fas fa-phone"></i> <span id="cv-phone">Phone</span></span>
                    <span><i class="fas fa-envelope"></i> <span id="cv-email">Email</span></span>
                    <span><i class="fas fa-globe"></i> <span id="cv-website">Website</span></span>
                </div>
            </div>

            <!-- Target/Objective Section -->
            <div class="section" id="cv-target-info">
                <h3 class="section-title">
                    <i class="fas fa-bullseye"></i>
                    Professional Summary
                </h3>
                <div class="section-content summary-content">
                    <p><span id="cv-target">Your professional summary goes here...</span></p>
                </div>
            </div>

            <!-- Experience Section -->
            <div class="section" id="cv-exp-info">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Experience
                </h3>
                <div class="timeline-container">
                    <div class="timeline-item" id="cv-exp">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h4><span id="cv-exp-pos">Position</span></h4>
                                <span class="timeline-date"><span id="cv-exp-time">Time Period</span></span>
                            </div>
                            <div class="timeline-company"><span id="cv-exp-company">Company Name</span></div>
                            <p><span id="cv-exp-content">Description of responsibilities and achievements...</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="section" id="cv-edu-info">
                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    Education
                </h3>
                <div class="timeline-container">
                    <div class="timeline-item" id="cv-edu">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h4><span id="cv-edu-major">Degree / Major</span></h4>
                                <span class="timeline-date"><span id="cv-edu-time">Time Period</span></span>
                            </div>
                            <div class="timeline-company"><span id="cv-edu-school">School Name</span></div>
                            <p><span id="cv-edu-content">Additional details about education...</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="section" id="cv-skill-info">
                <h3 class="section-title">
                    <i class="fas fa-star"></i>
                    Skills
                </h3>
                <div class="skills-grid">
                    <div class="skill-badge" id="cv-skill">
                        <span id="cv-skill-name">Skill Name</span>
                    </div>
                </div>
            </div>

            <!-- Activities Section -->
            <div class="section" id="cv-act-info">
                <h3 class="section-title">
                    <i class="fas fa-users"></i>
                    Activities & Involvement
                </h3>
                <div class="timeline-container">
                    <div class="timeline-item" id="cv-act">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h4><span id="cv-act-name">Activity Name</span></h4>
                                <span class="timeline-date"><span id="cv-act-time">Time Period</span></span>
                            </div>
                            <p><span id="cv-act-content">Description of activities...</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Awards Section -->
            <div class="section" id="cv-award-info">
                <h3 class="section-title">
                    <i class="fas fa-trophy"></i>
                    Awards & Achievements
                </h3>
                <div class="timeline-container">
                    <div class="timeline-item award-item" id="cv-award">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="award-header">
                                <h4><span id="cv-award-name">Award Name</span></h4>
                                <span class="timeline-date"><span id="cv-award-time">Year</span></span>
                            </div>
                            <p><span id="cv-award-content">Award description...</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="section" id="cv-additional-info">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Additional Information
                </h3>
                <div class="section-content summary-content">
                    <p><span id="cv-additional">Additional information goes here...</span></p>
                </div>
            </div>

            <!-- References Section -->
            <div class="section" id="cv-ref-info">
                <h3 class="section-title">
                    <i class="fas fa-handshake"></i>
                    References
                </h3>
                <div class="references-grid">
                    <div class="reference-item" id="cv-ref">
                        <h4><span id="cv-ref-name">Reference Name</span></h4>
                        <div class="ref-position"><span id="cv-ref-job">Job Title</span></div>
                        <div class="ref-company"><span id="cv-ref-company">Company Name</span></div>
                        <div class="ref-details">
                            <div><i class="fas fa-phone"></i> <span id="cv-ref-phone">Phone</span></div>
                            <div><i class="fas fa-envelope"></i> <span id="cv-ref-email">Email</span></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
