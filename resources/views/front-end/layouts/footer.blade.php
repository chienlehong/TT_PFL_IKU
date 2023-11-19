@include('front-end.layouts.button')
<form action="{{ route('cart.add') }}" id="data-form-add-to-cart" method="POST">
  {{ csrf_field() }}
  <input id="qty" type="number"  name="qty" value="1" min="1" max="100" hidden>
  <input id="data-input-add-to-cart" type="text"  name="txtBookId" value="" hidden min="1" max="100">
</form>
<footer class="page-footer" >
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">Contact me via Facebook</h5>
        <p class="grey-text text-lighten-4">
          <div class="fb-page"
          data-href=""
          data-small-header="true" data-adapt-container-width="false"
          data-hide-cover="false" data-show-facepile="true">
          <blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore">
          <a href="">Facebook</a></blockquote></div>
        </p>
      </div>
      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Liên kết</h5>
        <ul>
          <li><div class="g-ytsubscribe" data-channelid="UCHqJxLo7mKam9GKqqwr2wfA" data-layout="full" data-count="default"></div></li>
          <br>
          <script src="https://apis.google.com/js/platform.js"></script>


        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
    © {{date("Y")}} Copyright LeHongChien
    <a class="grey-text text-lighten-4 right" title="Click to get more free projects" target="_blank" href="https://www.youtube.com/channel/UCHqJxLo7mKam9GKqqwr2wfA?sub_confirmation=1">Get more free projects on my Youtube channel</a>
    </div>
  </div>
</footer>
