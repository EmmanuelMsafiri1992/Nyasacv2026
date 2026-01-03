<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('resume_public/resume_template/resume_bold_header/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="rb-layout">
        <div id="rb-main">
            <!-- Bold Header Section -->
            <header class="bold-header">
                <div class="header-content">
                    <div class="name-section">
                        <h1 class="name-title"><span id="cv-name">Your Name</span></h1>
                        <div class="title-underline"></div>
                    </div>
                    <h2 class="job-title"><span id="cv-job-position">Job Title / Professional Role</span></h2>
                    <div class="contact-grid">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span id="cv-addr">Address</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span id="cv-phone">Phone Number</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span id="cv-email">email@example.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-globe"></i>
                            <span id="cv-website">website.com</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Container -->
            <div class="content-container">

                <!-- Target/Objective Section -->
                <section class="section" id="cv-target-info">
                    <h3 class="section-title">
                        <span class="title-text">Professional Summary</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <p class="summary-text"><span id="cv-target">Your professional summary goes here. Highlight your key strengths, experiences, and career objectives in a compelling way.</span></p>
                    </div>
                </section>

                <!-- Experience Section -->
                <section class="section" id="cv-exp-info">
                    <h3 class="section-title">
                        <span class="title-text">Professional Experience</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <div class="experience-item" id="cv-exp">
                            <div class="exp-header">
                                <div class="exp-main">
                                    <h4 class="exp-position"><span id="cv-exp-pos">Position Title</span></h4>
                                    <div class="exp-company"><span id="cv-exp-company">Company Name</span></div>
                                </div>
                                <div class="exp-period"><span id="cv-exp-time">Jan 2020 - Present</span></div>
                            </div>
                            <div class="exp-description">
                                <p><span id="cv-exp-content">Description of your role, responsibilities, and key achievements. Use bullet points or paragraphs to highlight your contributions.</span></p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Education Section -->
                <section class="section" id="cv-edu-info">
                    <h3 class="section-title">
                        <span class="title-text">Education</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <div class="education-item" id="cv-edu">
                            <div class="edu-header">
                                <div class="edu-main">
                                    <h4 class="edu-degree"><span id="cv-edu-major">Degree / Major</span></h4>
                                    <div class="edu-school"><span id="cv-edu-school">University Name</span></div>
                                </div>
                                <div class="edu-period"><span id="cv-edu-time">2016 - 2020</span></div>
                            </div>
                            <div class="edu-description">
                                <p><span id="cv-edu-content">Additional details about your education, honors, relevant coursework, or achievements.</span></p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Skills Section -->
                <section class="section" id="cv-skill-info">
                    <h3 class="section-title">
                        <span class="title-text">Skills & Expertise</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <div class="skills-container">
                            <div class="skill-group" id="cv-skill">
                                <div class="skill-header">
                                    <span class="skill-name"><span id="cv-skill-name">Skill Name</span></span>
                                    <span class="skill-level">Expert</span>
                                </div>
                                <div class="skill-bar-wrapper">
                                    <div class="skill-bar" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Activities Section -->
                <section class="section" id="cv-act-info">
                    <h3 class="section-title">
                        <span class="title-text">Activities & Involvement</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <div class="activity-item" id="cv-act">
                            <div class="activity-header">
                                <h4 class="activity-name"><span id="cv-act-name">Activity or Organization Name</span></h4>
                                <div class="activity-period"><span id="cv-act-time">Time Period</span></div>
                            </div>
                            <div class="activity-description">
                                <p><span id="cv-act-content">Description of your involvement and contributions...</span></p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Awards Section -->
                <section class="section" id="cv-award-info">
                    <h3 class="section-title">
                        <span class="title-text">Awards & Recognition</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <div class="award-item" id="cv-award">
                            <div class="award-header">
                                <h4 class="award-name"><i class="fas fa-award"></i> <span id="cv-award-name">Award Name</span></h4>
                                <span class="award-year"><span id="cv-award-time">2020</span></span>
                            </div>
                            <div class="award-description">
                                <p><span id="cv-award-content">Description of the award and why it was received...</span></p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Additional Info Section -->
                <section class="section" id="cv-additional-info">
                    <h3 class="section-title">
                        <span class="title-text">Additional Information</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <p><span id="cv-additional">Languages, certifications, volunteer work, hobbies, or other relevant information...</span></p>
                    </div>
                </section>

                <!-- References Section -->
                <section class="section" id="cv-ref-info">
                    <h3 class="section-title">
                        <span class="title-text">References</span>
                        <span class="title-line"></span>
                    </h3>
                    <div class="section-content">
                        <div class="references-grid">
                            <div class="reference-card" id="cv-ref">
                                <h4 class="ref-name"><span id="cv-ref-name">Reference Name</span></h4>
                                <div class="ref-title"><span id="cv-ref-job">Job Title</span></div>
                                <div class="ref-company"><span id="cv-ref-company">Company Name</span></div>
                                <div class="ref-contacts">
                                    <div class="ref-contact-item">
                                        <i class="fas fa-phone"></i>
                                        <span id="cv-ref-phone">Phone</span>
                                    </div>
                                    <div class="ref-contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <span id="cv-ref-email">Email</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</body>
</html>
