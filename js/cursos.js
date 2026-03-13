/* Custom interactions for courses */
document.addEventListener("DOMContentLoaded", () => {
  // Checkout simulated button feedback
  const checkoutBtn = document.querySelector(
    '.checkout-wrapper button[type="submit"]',
  );
  if (checkoutBtn) {
    checkoutBtn.addEventListener("click", function (e) {
      // Check HTML5 validity
      if (this.form.checkValidity()) {
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        this.classList.add("disabled");
      }
    });
  }

  // Animate successful purchase elements if they exist
  const successBanners = document.querySelectorAll(".status-box.success");
  successBanners.forEach((banner) => {
    banner.style.transform = "scale(0.9)";
    banner.style.opacity = "0";
    setTimeout(() => {
      banner.style.transition =
        "all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
      banner.style.transform = "scale(1)";
      banner.style.opacity = "1";
    }, 300);
  });
});
