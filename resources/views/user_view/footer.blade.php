<!-- Reusable footer partial for user pages. -->
<!-- Include via footer -->
<!-- Uses Bootstrap utility classes to match header styling. -->
<!-- Updated copyrightto Payvance Innovations Pvt Ltd -->
<footer class="mt-4 py-3">
  <a href="{{ route('privacy_policy_pdf') }}" target="_blank" class="text-decoration-none w-100 d-block" title="Open Privacy Policy" style="cursor:pointer;">
    <div class="d-flex align-items-center justify-content-center gap-2">
      <img src="{{ asset('user_end/images/STPLLogo.png') }}" alt="Logo" class="me-2" style="height:26px;width:auto;">
      <span class="text-muted small">© {{ date('Y') }} Payvance Innovations Pvt Ltd. All rights reserved.</span>
    </div>
  </a>
</footer>
