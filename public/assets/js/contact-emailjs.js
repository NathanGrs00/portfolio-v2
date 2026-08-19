const EMAILJS_PUBLIC_KEY = "D25d4tqpGuc6a697G";
const EMAILJS_SERVICE_ID = "service_sfhgv1e";
const EMAILJS_TEMPLATE_ID = "template_8fg8x9i";

const RATE_LIMIT_KEY = "contact_form_last_sent";
const RATE_LIMIT_MS = 60 * 60 * 1000; // 1 hour

document.addEventListener("DOMContentLoaded", function () {
  emailjs.init({ publicKey: EMAILJS_PUBLIC_KEY });

  const form = document.getElementById("contact-form");
  const alertBox = document.getElementById("form-alert");
  const sendBtn = document.getElementById("send-btn");
  const sendBtnLabel = document.getElementById("send-btn-label");

  if (!form) return;

  function showAlert(type, message) {
    alertBox.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
  }

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    alertBox.innerHTML = "";

    // Honeypot check
    const honeypot = form.website.value.trim();

    if (honeypot !== "") {
      // Silently reject bots
      return;
    }

    // 1-hour rate limit
    const lastSent = Number(localStorage.getItem(RATE_LIMIT_KEY)) || 0;
    const now = Date.now();

    if (now - lastSent < RATE_LIMIT_MS) {
      const remainingMs = RATE_LIMIT_MS - (now - lastSent);
      const remainingMinutes = Math.ceil(remainingMs / 60000);

      showAlert(
        "error",
        `You've already sent a message recently. Please try again in about ${remainingMinutes} minute${remainingMinutes === 1 ? "" : "s"}.`,
      );

      return;
    }

    const emailValue = form.from_email.value.trim();
    const messageValue = form.message.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(emailValue)) {
      showAlert("error", "Please enter a valid email address.");
      return;
    }
    if (messageValue === "") {
      showAlert("error", "Please enter a message.");
      return;
    }

    sendBtn.disabled = true;
    sendBtnLabel.textContent = "Sending…";

    emailjs
      .send(EMAILJS_SERVICE_ID, EMAILJS_TEMPLATE_ID, {
        from_email: emailValue,
        message: messageValue,
      })
      .then(function () {
        localStorage.setItem(RATE_LIMIT_KEY, Date.now().toString());
        showAlert(
          "success",
          "Thanks — your message was sent. I'll get back to you soon.",
        );
        form.reset();
      })
      .catch(function (err) {
        console.error("EmailJS error:", err);
        showAlert(
          "error",
          "Something went wrong sending your message. Please try emailing directly instead.",
        );
      })
      .finally(function () {
        sendBtn.disabled = false;
        sendBtnLabel.textContent = "Send message";
      });
  });
});
