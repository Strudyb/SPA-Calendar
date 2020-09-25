
<div id="contentWrapper">
    <div class="page-title title-1">
        <div class="container">
            <div class="row">
                <div class="cell-12">
                    <h1 class="fx" data-animate="fadeInLeft">{{$page->title}}</h1>

                </div>
            </div>
        </div>
    </div>

	<div class="page-content ">

        <div class="padd-top-50">
            <div class="container">
				<div class="col-lg-3 col-md-4 mb-xs-35">
					<!--=======  contact page side content  =======-->
                    {!! html_entity_decode($page->content) !!}
					<!--=======  End of contact form content =======-->
				</div>
			</div>
		</div>
	</div>

	<!--=====  End of Contact page content  ======-->


	<!--=============================================
	=            Footer         =
	=============================================-->



	<!--=====  End of Footer  ======-->


	<!-- scroll to top  -->
	<a href="/" class="scroll-top"></a>
	<!-- end of scroll to top -->



