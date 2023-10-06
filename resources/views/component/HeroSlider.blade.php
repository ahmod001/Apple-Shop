<div id="carouselExample" class="carousel slide banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div id="carouselSection" class="carousel-inner"></div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<script>
    async function Hero() {
        const res = await axios.get("/product-slider-list");
        $("#carouselSection").empty();
        res.data['data'].forEach((item, i) => {

            const SliderItem = `<div id=${i} class="carousel-item  background_bg ${i===0&&'active'}" style="background-image: url('${item['img']}')">
                <div class="banner_slide_content">
                    <div class="container"><!-- STRART CONTAINER -->
                        <div class="row">
                            <div class="col-lg-7 col-9">
                                <div class="banner_content overflow-hidden">
                                    <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">${item['price']}</h5>
                                    <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">${item['title']}</h2>
                                    <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="#" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- END CONTAINER-->
                </div>
            </div>`
            $("#carouselSection").append(SliderItem)
        })
    }
</script>
