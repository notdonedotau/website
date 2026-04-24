@extends('layouts.site', [
    'title' => 'Careers | notdone.au',
    'description' => 'Careers at Not Done Pty Ltd.',
])

@section('content')
    <section class="content-page careers-page">
        <p class="eyebrow">Careers</p>
        <h1>Careers at Not Done Pty Ltd</h1>
        <p class="page-intro">
            Not Done Pty Ltd builds practical digital systems for businesses.
            We are still early-stage, and our product JMCO.cx is currently in
            development. That means the work is focused, hands-on, and still
            close to the problems we are solving.
        </p>

        <section class="careers-section">
            <h2>Our Approach</h2>
            <div class="careers-copy">
                <p>
                    We focus on building useful systems that are clear to use
                    and reliable enough to support real business operations.
                </p>
                <ul>
                    <li>Reliable systems</li>
                    <li>Ease of use</li>
                    <li>Continuous improvement</li>
                </ul>
            </div>
        </section>

        <section class="careers-section">
            <div>
                <h2>Open Roles</h2>
                <p class="section-note">All roles are based in Perth, Western Australia.</p>
            </div>

            <div class="role-grid">
                <article class="role-card">
                    <div class="role-card__meta">
                        <span class="role-tag">Engineering</span>
                        <span>Perth, Western Australia</span>
                    </div>
                    <h3>Full Stack Software Engineer</h3>
                    <p>
                        Work across product features, internal tools, and
                        integrations that support JMCO.cx and related systems.
                    </p>
                    <p class="role-card__label">Responsibilities</p>
                    <ul>
                        <li>Build and maintain Laravel-based applications</li>
                        <li>Develop practical frontend interfaces and workflows</li>
                        <li>Work on integrations, automation, and internal tooling</li>
                        <li>Improve reliability, maintainability, and performance over time</li>
                    </ul>
                </article>

                <article class="role-card">
                    <div class="role-card__meta">
                        <span class="role-tag">Support</span>
                        <span>Perth, Western Australia</span>
                    </div>
                    <h3>Technical Support / Customer Operations</h3>
                    <p>
                        Support customers, improve operational processes, and
                        help identify where systems can be made clearer.
                    </p>
                    <p class="role-card__label">Responsibilities</p>
                    <ul>
                        <li>Respond to customer questions clearly and professionally</li>
                        <li>Document common issues, processes, and resolutions</li>
                        <li>Share product and service feedback with the team</li>
                        <li>Help improve customer-facing workflows and operations</li>
                    </ul>
                </article>
            </div>
        </section>

        <section class="careers-section">
            <h2>Working With Us</h2>
            <div class="careers-copy">
                <p>
                    We are a small team, so responsibilities can evolve as the
                    business grows. Clear communication and reliable follow
                    through matter here.
                </p>
                <ul>
                    <li>Communication</li>
                    <li>Reliability</li>
                    <li>Willingness to learn</li>
                </ul>
            </div>
        </section>

        <section class="careers-section careers-apply">
            <h2>Apply</h2>
            <div class="careers-copy">
                <p>
                    Email <a href="mailto:careers@notdone.au">careers@notdone.au</a>.
                </p>
                <p>Please include:</p>
                <ul>
                    <li>A short introduction</li>
                    <li>Your relevant experience</li>
                    <li>Examples of work you have done</li>
                </ul>
            </div>
        </section>
    </section>
@endsection
