@extends('layouts.dashboard')

@section('title', __('AI Resume Assistant'))
@section('header-title', __('AI Resume Assistant'))

@section('content')
<div class="dashboard-content">
    <div class="mb-4">
        <h2 class="mb-1">@lang('AI Resume Assistant')</h2>
        <p class="text-muted mb-0">@lang('Generate professional content for your resume with our intelligent assistant')</p>
    </div>

    <div class="row">
        <!-- Left Column: Input Form -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('Your Information')</h4>
                </div>
                <div class="card-body">
                    <form id="ai-form">
                        <div class="form-group">
                            <label class="form-label">@lang('Job Title') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="job_title" name="job_title" placeholder="e.g., Software Engineer, Marketing Manager" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Industry')</label>
                            <select class="form-control" id="industry" name="industry">
                                <option value="">@lang('Select Industry')</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->name }}">{{ $industry->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Years of Experience') <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="years_experience" name="years_experience" min="0" max="50" value="3" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Key Skills') <small class="text-muted">(@lang('comma separated'))</small></label>
                            <input type="text" class="form-control" id="skills" name="skills" placeholder="e.g., JavaScript, Project Management, Leadership">
                            <small class="text-muted">@lang('Enter your top skills to personalize the content')</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Tone')</label>
                            <select class="form-control" id="tone" name="tone">
                                <option value="professional">@lang('Professional')</option>
                                <option value="creative">@lang('Creative')</option>
                                <option value="executive">@lang('Executive')</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Generate Buttons -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('Generate Content')</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <button type="button" class="btn btn-primary btn-block" onclick="generateSummary()">
                                <i class="fe fe-user mr-2"></i>@lang('Summary')
                            </button>
                        </div>
                        <div class="col-6 mb-3">
                            <button type="button" class="btn btn-success btn-block" onclick="generateBullets()">
                                <i class="fe fe-list mr-2"></i>@lang('Bullet Points')
                            </button>
                        </div>
                        <div class="col-6 mb-3">
                            <button type="button" class="btn btn-info btn-block" onclick="suggestSkills()">
                                <i class="fe fe-zap mr-2"></i>@lang('Suggest Skills')
                            </button>
                        </div>
                        <div class="col-6 mb-3">
                            <button type="button" class="btn btn-warning btn-block" onclick="showCoverLetterModal()">
                                <i class="fe fe-file-text mr-2"></i>@lang('Cover Letter')
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bullet Point Enhancer -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">@lang('Enhance Bullet Point')</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">@lang('Paste your bullet point')</label>
                        <textarea class="form-control" id="enhance_text" rows="2" placeholder="e.g., Worked on improving sales"></textarea>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-block" onclick="enhanceBullet()">
                        <i class="fe fe-trending-up mr-2"></i>@lang('Enhance This Bullet')
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Results -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">@lang('Generated Content')</h4>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearResults()" id="clear-btn" style="display: none;">
                        <i class="fe fe-x mr-1"></i>@lang('Clear')
                    </button>
                </div>
                <div class="card-body" id="results-container">
                    <div id="loading" style="display: none;" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">@lang('Generating...')</span>
                        </div>
                        <p class="mt-3 text-muted">@lang('AI is generating content...')</p>
                    </div>

                    <div id="placeholder" class="text-center py-5">
                        <i class="fe fe-cpu" style="font-size: 60px; color: #e0e0e0;"></i>
                        <h4 class="mt-3 text-muted">@lang('AI Assistant Ready')</h4>
                        <p class="text-muted">@lang('Fill in your information and click a generate button to create professional content')</p>
                    </div>

                    <div id="results" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cover Letter Modal -->
<div class="modal fade" id="coverLetterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Generate Cover Letter')</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">@lang('Company Name') <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="company_name" placeholder="e.g., Google, Microsoft">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Recipient Name')</label>
                    <input type="text" class="form-control" id="recipient_name" placeholder="e.g., John Smith (or leave blank for 'Hiring Manager')">
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Letter Type')</label>
                    <select class="form-control" id="letter_type">
                        <option value="general">@lang('General Application')</option>
                        <option value="referral">@lang('Referral')</option>
                        <option value="career_change">@lang('Career Change')</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                <button type="button" class="btn btn-primary" onclick="generateCoverLetter()">@lang('Generate')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const csrfToken = '{{ csrf_token() }}';

function getFormData() {
    const skills = document.getElementById('skills').value;
    return {
        job_title: document.getElementById('job_title').value,
        industry: document.getElementById('industry').value,
        years_experience: parseInt(document.getElementById('years_experience').value) || 3,
        skills: skills ? skills.split(',').map(s => s.trim()).filter(s => s) : [],
        tone: document.getElementById('tone').value
    };
}

function showLoading() {
    document.getElementById('loading').style.display = 'block';
    document.getElementById('placeholder').style.display = 'none';
    document.getElementById('results').style.display = 'none';
}

function showResults(html) {
    document.getElementById('loading').style.display = 'none';
    document.getElementById('placeholder').style.display = 'none';
    document.getElementById('results').style.display = 'block';
    document.getElementById('results').innerHTML = html;
    document.getElementById('clear-btn').style.display = 'inline-block';
}

function clearResults() {
    document.getElementById('results').style.display = 'none';
    document.getElementById('placeholder').style.display = 'block';
    document.getElementById('clear-btn').style.display = 'none';
}

function showError(message) {
    showResults(`<div class="alert alert-danger"><i class="fe fe-alert-circle mr-2"></i>${message}</div>`);
}

function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fe fe-check"></i> Copied!';
        btn.classList.add('btn-success');
        btn.classList.remove('btn-outline-secondary');
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

async function generateSummary() {
    const data = getFormData();
    if (!data.job_title) {
        alert('@lang("Please enter a job title")');
        return;
    }

    showLoading();
    try {
        const response = await fetch('{{ route("resume.ai.generate-summary") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ ...data, count: 3 })
        });

        const result = await response.json();
        if (result.success) {
            let html = '<h5 class="mb-3"><i class="fe fe-user mr-2"></i>@lang("Professional Summaries")</h5>';
            result.data.forEach((item, index) => {
                html += `
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge badge-${item.tone === 'executive' ? 'warning' : (item.tone === 'creative' ? 'info' : 'primary')}">${item.tone}</span>
                                <small class="text-muted">${item.word_count} words</small>
                            </div>
                            <p class="mb-2" id="summary-${index}">${item.text}</p>
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard(document.getElementById('summary-${index}').innerText, this)">
                                <i class="fe fe-copy mr-1"></i>@lang("Copy")
                            </button>
                        </div>
                    </div>
                `;
            });
            showResults(html);
        } else {
            showError(result.message || '@lang("Failed to generate summary")');
        }
    } catch (error) {
        showError('@lang("An error occurred. Please try again.")');
    }
}

async function generateBullets() {
    const data = getFormData();
    if (!data.job_title) {
        alert('@lang("Please enter a job title")');
        return;
    }

    showLoading();
    try {
        const response = await fetch('{{ route("resume.ai.generate-bullets") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ ...data, count: 6, include_metrics: true })
        });

        const result = await response.json();
        if (result.success) {
            let html = '<h5 class="mb-3"><i class="fe fe-list mr-2"></i>@lang("Achievement Bullet Points")</h5>';
            html += '<div class="card"><div class="card-body"><ul class="mb-0">';
            result.data.forEach((item, index) => {
                html += `
                    <li class="mb-3 d-flex justify-content-between align-items-start">
                        <span id="bullet-${index}">${item.text}</span>
                        <button class="btn btn-sm btn-outline-secondary ml-2 flex-shrink-0" onclick="copyToClipboard(document.getElementById('bullet-${index}').innerText, this)">
                            <i class="fe fe-copy"></i>
                        </button>
                    </li>
                `;
            });
            html += '</ul></div></div>';
            html += `<button class="btn btn-outline-primary mt-3" onclick="generateBullets()"><i class="fe fe-refresh-cw mr-2"></i>@lang("Generate More")</button>`;
            showResults(html);
        } else {
            showError(result.message || '@lang("Failed to generate bullet points")');
        }
    } catch (error) {
        showError('@lang("An error occurred. Please try again.")');
    }
}

async function suggestSkills() {
    const data = getFormData();
    if (!data.job_title) {
        alert('@lang("Please enter a job title")');
        return;
    }

    showLoading();
    try {
        const response = await fetch('{{ route("resume.ai.suggest-skills") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                job_title: data.job_title,
                industry: data.industry,
                existing_skills: data.skills,
                count: 15
            })
        });

        const result = await response.json();
        if (result.success) {
            let html = '<h5 class="mb-3"><i class="fe fe-zap mr-2"></i>@lang("Suggested Skills")</h5>';
            html += '<div class="card"><div class="card-body">';

            const categories = {};
            result.data.forEach(skill => {
                if (!categories[skill.category]) categories[skill.category] = [];
                categories[skill.category].push(skill);
            });

            for (const [category, skills] of Object.entries(categories)) {
                const categoryLabel = category.charAt(0).toUpperCase() + category.slice(1);
                html += `<h6 class="text-muted mb-2">${categoryLabel}</h6><div class="mb-3">`;
                skills.forEach(skill => {
                    html += `<span class="badge badge-${category === 'soft' ? 'success' : (category === 'tools' ? 'warning' : 'primary')} mr-2 mb-2" style="font-size: 0.9rem; cursor: pointer;" onclick="addSkill('${skill.name}')">${skill.name} <i class="fe fe-plus ml-1"></i></span>`;
                });
                html += '</div>';
            }

            html += '</div></div>';
            html += '<small class="text-muted">@lang("Click a skill to add it to your list")</small>';
            showResults(html);
        } else {
            showError(result.message || '@lang("Failed to suggest skills")');
        }
    } catch (error) {
        showError('@lang("An error occurred. Please try again.")');
    }
}

function addSkill(skill) {
    const input = document.getElementById('skills');
    const currentSkills = input.value ? input.value.split(',').map(s => s.trim()) : [];
    if (!currentSkills.includes(skill)) {
        currentSkills.push(skill);
        input.value = currentSkills.join(', ');
    }
}

async function enhanceBullet() {
    const text = document.getElementById('enhance_text').value.trim();
    if (!text) {
        alert('@lang("Please enter a bullet point to enhance")');
        return;
    }

    showLoading();
    try {
        const response = await fetch('{{ route("resume.ai.enhance-bullet") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                text: text,
                job_title: document.getElementById('job_title').value,
                add_metrics: true
            })
        });

        const result = await response.json();
        if (result.success && result.data.enhancements) {
            let html = '<h5 class="mb-3"><i class="fe fe-trending-up mr-2"></i>@lang("Enhanced Versions")</h5>';
            html += `<div class="card mb-3 bg-light"><div class="card-body"><strong>@lang("Original"):</strong><br>${result.data.original}</div></div>`;

            result.data.enhancements.forEach((item, index) => {
                html += `
                    <div class="card mb-2">
                        <div class="card-body">
                            <span class="badge badge-info mb-2">${item.improvement}</span>
                            <p class="mb-2" id="enhanced-${index}">${item.text}</p>
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard(document.getElementById('enhanced-${index}').innerText, this)">
                                <i class="fe fe-copy mr-1"></i>@lang("Copy")
                            </button>
                        </div>
                    </div>
                `;
            });
            showResults(html);
        } else {
            showError(result.message || '@lang("Failed to enhance bullet point")');
        }
    } catch (error) {
        showError('@lang("An error occurred. Please try again.")');
    }
}

function showCoverLetterModal() {
    if (!document.getElementById('job_title').value) {
        alert('@lang("Please enter a job title first")');
        return;
    }
    $('#coverLetterModal').modal('show');
}

async function generateCoverLetter() {
    const company = document.getElementById('company_name').value.trim();
    if (!company) {
        alert('@lang("Please enter a company name")');
        return;
    }

    $('#coverLetterModal').modal('hide');
    showLoading();

    const data = getFormData();
    try {
        const response = await fetch('{{ route("resume.ai.generate-cover-letter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                ...data,
                company: company,
                recipient_name: document.getElementById('recipient_name').value || 'Hiring Manager',
                type: document.getElementById('letter_type').value
            })
        });

        const result = await response.json();
        if (result.success) {
            let html = '<h5 class="mb-3"><i class="fe fe-file-text mr-2"></i>@lang("Cover Letter")</h5>';
            html += `<div class="card"><div class="card-body">`;
            html += `<pre style="white-space: pre-wrap; font-family: inherit; margin: 0;" id="cover-letter">${result.data.full_text}</pre>`;
            html += `</div></div>`;
            html += `<div class="mt-3">
                <button class="btn btn-outline-secondary" onclick="copyToClipboard(document.getElementById('cover-letter').innerText, this)">
                    <i class="fe fe-copy mr-2"></i>@lang("Copy to Clipboard")
                </button>
                <small class="text-muted ml-3">${result.data.word_count} @lang("words")</small>
            </div>`;
            showResults(html);
        } else {
            showError(result.message || '@lang("Failed to generate cover letter")');
        }
    } catch (error) {
        showError('@lang("An error occurred. Please try again.")');
    }
}
</script>
@endsection
