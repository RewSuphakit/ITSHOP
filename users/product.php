<!-- product.php -->
<?php
include('../menu/menu_user.php');
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("Location: ../login");
    exit();
}
$user_id = $_SESSION['user_id'];
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);
$category_filter = isset($_GET['category']) ? $_GET['category'] : (isset($_SESSION['selectedCategory']) ? $_SESSION['selectedCategory'] : null);
$search_term = isset($_GET['search']) ? $_GET['search'] : (isset($_SESSION['searchTerm']) ? $_SESSION['searchTerm'] : null);
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : (isset($_SESSION['selectedSort']) ? $_SESSION['selectedSort'] : 'desc');
?>

<style>
       
    .out-of-stock {
        opacity: 0.5;
        filter: grayscale(100%);
    }

    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .product-price {
        font-size: 20px;
        color: #e44d26;
        margin-bottom: 10px;
        padding-bottom: 10px;
    }

    .product-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s;
        height: 100%;
        cursor: pointer;
    }

    .product-card:hover {
        transform: scale(1.05);

    }

    .badgee {
        position: absolute;
        top: 0;
        left: 0;
        background-color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0 0.5rem 0.5rem;
        font-size: 0.75rem;
    }
   

</style>
<script src="https://unpkg.com/typed.js@2.0.132/dist/typed.umd.js"></script>
<!-- <h2><span id="element"></span></h2> -->
<div class="container">

    <form action="product.php" method="get">
        <div class="row justify-content g-2 g-lg-3 ">
            <div class="col p-3">
                <select name="category" id="category" class="form-select" aria-label="Default select example" onchange="this.form.submit();">
                    <option value="">ทั้งหมด</option>
                    <?php
                    if ($categories_result) {   
                        while ($category = mysqli_fetch_assoc($categories_result)) {
                            echo "<option value='" . $category['category_id'] . "'>" . $category['category_name'] . "</option>";
                        }
                        mysqli_free_result($categories_result);
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                    ?>
                </select>
            </div>
            <div class="col p-3">
                <select name="sort" id="sort" class="form-select" aria-label="Default select example" onchange="this.form.submit();">
                    <option value="desc" <?php echo $sortOption === 'desc' ? 'selected' : ''; ?>>ราคา: มากไปน้อย</option>
                    <option value="asc" <?php echo $sortOption === 'asc' ? 'selected' : ''; ?>>ราคา: น้อยไปมาก</option>
                    <option value="latest" <?php echo $sortOption === 'latest' ? 'selected' : ''; ?>>ปรับปรุงล่าสุด</option>
                </select>
            </div>


            <div class="col-md-6 p-3">
    <div class="input-group">
        <input type="search"  autocomplete="off"  class="form-control" name="search" id="search" placeholder="ค้นหาชื่อสินค้าที่ต้องการได้ที่นี่......" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
       &nbsp;
        <div class="input-group-append">
            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <div id="autocomplete-results"></div>
</div>
 


            <script>
                timeout_var = null;

                function typeWriter(selector_target, text_list, placeholder = false, i = 0, text_list_i = 0, delay_ms = 200) {
                    if (!i) {
                        if (placeholder) {
                            document.querySelector(selector_target).placeholder = "";
                        } else {
                            document.querySelector(selector_target).innerHTML = "";
                        }
                    }
                    txt = text_list[text_list_i];
                    if (i < txt.length) {
                        if (placeholder) {
                            document.querySelector(selector_target).placeholder += txt.charAt(i);
                        } else {
                            document.querySelector(selector_target).innerHTML += txt.charAt(i);
                        }
                        i++;
                        setTimeout(typeWriter, delay_ms, selector_target, text_list, placeholder, i, text_list_i);
                    } else {
                        text_list_i++;
                        if (typeof text_list[text_list_i] === "undefined") {
                            setTimeout(typeWriter, (delay_ms * 10), selector_target, text_list, placeholder);
                        } else {
                            i = 0;
                            setTimeout(typeWriter, (delay_ms * 3), selector_target, text_list, placeholder, i, text_list_i);
                        }
                    }
                }

                text_list = [
                    "ค้นหาชื่อสินค้าที่ต้องการได้ที่นี่....."
                    

                ];

                return_value = typeWriter("#search", text_list, true);



                // var element = new Typed('#element', {
                //         strings: ['ยินดีต้อนรับเข้าสู่เว็บขายอุปกรณ์คอมพิวเตอร์'],
                //         typeSpeed: 50,
                //         backSpeed: 1,
                //         smartBackspace: true, // this is a default
                //         loop: true,
                //         backDelay: 4000,
                //         backSpeed: 0,
                //     });
            </script>




    </form>
</div>
<?php
$pageSize = 18; // Number of products to display per page
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'desc';
$orderBy = '';

if ($sortOption === 'asc') {
    $orderBy = 'ORDER BY product_price ASC, dateup ASC';
} else if ($sortOption === 'latest') {
    $orderBy = 'ORDER BY dateup DESC';
} else {
    $orderBy = 'ORDER BY product_price DESC, dateup DESC';
}

$category_filter = isset($_GET['category']) ? $_GET['category'] : null;
$search_term = isset($_GET['search']) ? $_GET['search'] : null;

$where_clause = "";
if ($category_filter) {
    $where_clause .= " WHERE product_category_id = $category_filter";
}

if ($search_term) {
    $where_clause .= ($where_clause ? " AND" : " WHERE") . " product_name LIKE '%$search_term%'";
}

$query = "SELECT COUNT(*) as total FROM products $where_clause";
$totalResult = mysqli_query($con, $query);
$totalRow = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($totalRow / $pageSize);

if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

if ($currentPage < 1) {
    $currentPage = 1;
}

$offset = ($currentPage - 1) * $pageSize;
$query = "SELECT * FROM products $where_clause $orderBy LIMIT $offset, $pageSize";
$result = mysqli_query($con, $query);;

if ($result) {
?>
    <section class="py-3">
        <div class="container">
            <div class="row gx-4 ">
                <!-- Inside the while loop where you display product cards -->
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="mb-3 col-6  col-sm-2" onclick="redirectToProductDetail(<?php echo $row["product_id"]; ?>)">
                        <div class="card product-card">
                            <div class="badgee"><?php echo $row['product_brand']; ?></div>
                            <img class="card-img-top img-fluid <?php if ($row["product_stock"] == 0) echo "out-of-stock"; ?>" height="250px" style="object-fit: cover;" alt="Card image cap" src="../product_image/<?php echo $row['product_img']; ?>">
                            <div class="card-body p-3">
                                <h7 class="card-title "><?php echo $row["product_name"]; ?></h7>
                            </div>
                            <p class="card-text product-price text-center"> <?php echo number_format($row["product_price"]); ?> บาท</p>

                        </div>
                    </div>
                <?php } ?>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#search').keyup(function() {
                            var query = $(this).val();

                            if (query.length >= 2) {
                                $.ajax({
                                    url: 'autocomplete.php',
                                    method: 'POST',
                                    data: {
                                        query: query
                                    },
                                    success: function(data) {
                                        $('#autocomplete-results').html(data);
                                        $('#autocomplete-results').show();
                                    },
                                    error: function(error) {
                                        console.log('Error:', error);
                                    }
                                });
                            } else {
                                $('#autocomplete-results').hide();
                            }
                        });

                        $(document).on('click', '.autocomplete-item', function() {
                            var selectedValue = $(this).text();
                            $('#search').val(selectedValue);
                            $('#autocomplete-results').hide();
                        });
                    });
                </script>



                <script>
                    function redirectToProductDetail(productId) {
                        window.location.href = 'product_detail.php?product_id=' + productId;
                    }
                    // เมื่อกดค้นหา
                    document.querySelector('button[type="submit"]').addEventListener('click', function() {
                        // เก็บค่าที่เลือกใน sessionStorage
                        var categoryValue = document.getElementById('category').value;
                        var searchValue = document.getElementById('search').value;
                        var sortValue = document.getElementById('sort').value;


                        sessionStorage.setItem('selectedCategory', categoryValue);
                        sessionStorage.setItem('searchTerm', searchValue);
                        sessionStorage.setItem('selectedSort', sortValue);
                    });
                </script>


            </div>
            <!-- เพิ่ม pagination -->
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        for ($i = 1; $i <= $totalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>"><a class="page-link" href="product.php?page=<?php echo $i; ?>&sort=<?php echo $sortOption; ?>&category=<?php echo $category_filter; ?>"><?php echo $i; ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!-- <?php include '/components/footer.php'; ?> -->
<?php
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>