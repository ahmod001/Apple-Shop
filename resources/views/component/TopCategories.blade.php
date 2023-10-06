<div class="section">
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Categories</h2>
                </div>
                <p class="text-center leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit
                    massa enim Nullam nunc varius.</p>
            </div>
        </div>
        <div id="TopCategoryItem" class="d-flex align-items-center"></div>
    </div>
</div>


<script>
    async function TopCategory() {
        
        const res = await axios.get("/category-list");
        $("#TopCategoryItem").empty()

        res.data['data'].forEach((item, i) => {
            const EachItem =
                `<div class="p-2 col-2">
                    <div class="item">
                        <div class="categories_box">
                            <a href="/by-category?id=${item['id']}">
                                <img src="${item['category_img']}" alt=${item['category_name']}/>
                                <span>${item['category_name']}</span>
                            </a>
                        </div>
                    </div>
              </div>`
            $("#TopCategoryItem").append(EachItem);
        })
    }
</script>
