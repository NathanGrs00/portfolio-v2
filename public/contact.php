<?php
require_once __DIR__ . '/../data/db.php';

$profileRows = supabaseRequest('about?select=*');
$profile     = $profileRows[0] ?? [];

$toEmail      = $profile['email']              ?? 'nathangeers2@gmail.com';
$yourName     = 'Nathan Geers';
$location     = $profile['current_place']      ?? '';
$responseTime = 'Replies in ~24 hours';
$availability = 'Open to part-time and full-time';
$githubUrl    = $profile['github_url']         ?? '#';
$linkedinUrl  = $profile['linkedin_url']       ?? '#';
$cvPath       = $profile['cv_url']             ?? '#';

// ---- Form handling ----
$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $senderEmail = trim($_POST['email'] ?? '');
    $message     = trim($_POST['message'] ?? '');

    if ($senderEmail === '' || !filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($message === '') {
        $errors[] = "Please enter a message.";
    }

    if (empty($errors)) {
        $subject = "New contact form message from $senderEmail";
        $body    = "You received a new message via your portfolio contact form.\n\n"
                 . "From: $senderEmail\n\n"
                 . "Message:\n$message\n";

        $headers   = [];
        $headers[] = "From: {$yourName} <no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ">";
        $headers[] = "Reply-To: $senderEmail";
        $headers[] = "Content-Type: text/plain; charset=UTF-8";

        $sent = @mail($toEmail, $subject, $body, implode("\r\n", $headers));

        if ($sent) {
            $success = true;
        } else {
            $errors[] = "Something went wrong sending your message. Please try emailing directly instead.";
        }
    }
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<div class="contact-section" id="contact-section">

    <!-- Sidebar / alternative field -->
    <aside class="card sidebar">
        <span class="status-badge"><span class="status-dot"></span> Available</span>

        <h2><?= h($yourName) ?></h2>

        <div class="meta-list">
            <div class="meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <?= h($location) ?>
            </div>
            <div class="meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <?= h($responseTime) ?>
            </div>
            <div class="meta-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <?= h($availability) ?>
            </div>
        </div>

        <div class="social-row">
            <a class="icon-btn" href="<?= h($githubUrl) ?>" target="_blank" rel="noopener" aria-label="GitHub">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.1.79-.25.79-.56 0-.28-.01-1.02-.02-2-3.2.7-3.88-1.54-3.88-1.54-.52-1.33-1.28-1.69-1.28-1.69-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.19 1.77 1.19 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.55-.29-5.23-1.28-5.23-5.68 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.64 1.59.24 2.76.12 3.05.74.8 1.19 1.83 1.19 3.09 0 4.41-2.69 5.39-5.25 5.67.41.36.78 1.08.78 2.17 0 1.57-.01 2.83-.01 3.22 0 .31.2.67.8.56A10.99 10.99 0 0 0 23.5 12c0-6.35-5.15-11.5-11.5-11.5Z"/></svg>
            </a>
            <a class="icon-btn" href="<?= h($linkedinUrl) ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.45 20.45h-3.55v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.36V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12ZM7.11 20.45H3.56V9h3.55v11.45Z"/></svg>
            </a>
        </div>

        <hr>

        <a class="cv-btn" href="<?= h($cvPath) ?>" download>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/></svg>
            Download CV
        </a>
    </aside>

    <section class="card form-panel">
        <h2 class="form-title">Send a message</h2>
        <p class="form-sub">Prefer email? Reach me at <strong><?= h($toEmail) ?></strong></p>
 
        <div id="form-alert"></div>
 
        <form id="contact-form">
            <div class="honeypot" aria-hidden="true">
                <label for="website">Website</label>
                <input
                    type="text"
                    id="website"
                    name="website"
                    tabindex="-1"
                    autocomplete="off"
                >
            </div>

            <div class="field-group">
                <label class="field-label" for="email">Your email</label>
                <input type="email" id="email" name="from_email" placeholder="you@example.com" required>
            </div>
 
            <div class="field-group">
                <label class="field-label" for="message">Message</label>
                <textarea id="message" name="message" placeholder="Tell me about your project, idea, or opportunity..." required></textarea>
            </div>
 
            <button type="submit" id="send-btn" class="send-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                <span id="send-btn-label">Send message</span>
            </button>
        </form>
    </section>
 
</div>

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script src="/assets/js/contact-emailjs.js"></script>