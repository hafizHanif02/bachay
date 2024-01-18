<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
    crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title>profile-login</title>
</head>
<style>
@media screen and (max-width: 768px){
    body{
        font-family: 'poppins';
        padding: 0 10px;
    }
.profile-image img{

    border: 2px solid #000;
}
.profile_text1{
    color:#FF6D91;
}
.profile_text2{
    color:#8A68C5;
}
.para-1{
        font-size: 12px;
    }
    .Profile_ship{
        background-color: #845DC2;
        width: 127px;
        padding:2px 15px 2px 15px;
        top: 170px;
        right: 120px;
    }
    .profile_parenting{
        background-color: #F8931B;
        width: 127px;
        padding:2px 10px 2px 10px;
        top: 305px;
        right: 120px;
    }
    .line{
        width: 100%;
        height: 10px;
        background-color: #EDF2F4;
    }
    .image-box{
        margin-right: 2px;
    }
    .imge-1 img{
        width: 100%;
        height: 120px;
    }
    .para-2{
        font-size: 10px;
    }
    .img-1{
       background-color:  #845DC2;
       border-radius: 0px 0px 5px 5px;
    }
    .inner-text{
        font-size: 10px;
    }
    .item-1{
        border-bottom: 1px solid #80868E;  
    }
    .parenting{
        border: 1px solid #80868E;
        border-radius: 25px;
    }
}
</style>
<body>
    <div class=" d-flex justify-content-between align-items-center p-3">
   <div class="d-flex align-items-center">
    <div class="profile-image">
        <img class="rounded-circle" src="./first-image.jpeg" alt="" width="100px" height="100px">
    </div>
    <div class="ms-2">
        <p class="mb-0 fs-5 fw-semibold text-dark">Rabia Kausar</p>
        <div class="d-flex align-items-center">
            <img src="./profile-1.svg" alt="" width="12px" height="12px">
            <div>
                <p class="profile_text1 mb-0 fw-semibold">Mother Of 03</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <img src="./cart.svg" alt="" width="12px" height="12px">
            <div>
                <p class="profile_text2 mb-0 fw-semibold">2 Boys 1 Girl</p>
            </div>
        </div>
    </div>
   </div> 
   <div>
    <img src="./edit.svg" alt="" width="16px" height="16px">
   </div>
</div>
<div class="line mt-3"></div>
<div
        class=" d-flex justify-content-between rounded-pill ps-3 pe-3 pt-4 pb-2 border border-dark-subtle mt-4 p-3 align-items-center">
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./account.svg" alt="">
                </div>
                <p class="align-items-center">Account</p>
            </a>
        </div>
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./order.svg" alt="">
                </div>
                <p>Order History</p>
            </a>
        </div>
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./track.svg" alt="">
                </div>
                <p>Track Order</p>
            </a>
        </div>
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="cash.svg" alt="">
                </div>
                <p class="">Cash Refund</p>
            </a>
        </div>
    </div>
    <div>
        <p class="Profile_ship rounded-pill position-absolute fs-6 fw-bold text-center text-white">Shopping</p>
    </div>
    <div
        class="d-flex justify-content-between rounded-pill ps-3 pe-3 pt-4 pb-2 border border-dark-subtle mt-5 p-3 align-items-center">
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./feed.svg" alt="">
                </div>
                <p class="align-items-center">My Feed</p>
            </a>
        </div>
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./vaccine.svg" alt="">
                </div>
                <p>Vaccine & Growth</p>
            </a>
        </div>
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./sqa.svg" alt="">
                </div>
                <p>Expert Q&A</p>
            </a>
        </div>
        <div class="">
            <a class="para-1 fw-bold text-decoration-none text-dark" href="">
                <div class="text-center">
                    <img class="" src="./read.svg" alt="">
                </div>
                <p class="">Read</p>
            </a>
        </div>
    </div>
    <div>
        <p class="profile_parenting rounded-pill position-absolute fs-6 fw-bold text-center text-white">Parenting</p>
    </div>
    <div class="line mt-3"></div>
    <div div class="d-flex justify-content-between mt-3">
        <p class="fw-semibold mb-0">Recently View Products</p>
        <div class="d-flex align-items-center">
            <a class="text-primary text-decoration-none me-1" href="">View All</a>
            <div>
                <img class="mb-1" src="./right-arrow.svg" alt="">
            </div>
        </div>
    </div>
    <div class="line mt-3"></div>
    <div class="ps-3 pe-3">
        <p class="fs-6 fw-bold mt-3">Most View child’s Birth-club</p>
        
        <div class="mb-3 d-flex col-12 ">
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Animals & Birds</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <div class="">
                        <img class="object0fit-cover rounded" src="./shoes.jpeg" alt="">
                    </div>
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white ">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Hanky/Napkins</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <div>
                        <img class="rounded" src="./hanky napkins.jpeg" alt="">
                    </div>
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="border rounded pt-1 ">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Baby Toy Cleanners</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        
                        <img class="rounded" src="./bayb cleaners.jpeg" alt="">
                    
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
        </div>
        <div class="mb-5 d-flex col-12">
            <div class="col-4">
                <div class="border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Baby Toy Cleanners</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="hanky napkins.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white ">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Animals & Birds</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./shoes.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Hanky/Napkins</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./bayb cleaners.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
        </div>
        <div class="line mt-3"></div>
    
    
        <p class="fs-6 fw-bold mt-3">For your Growing Child</p>
        <div class="mb-3 d-flex">
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Animals & Birds</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./shoes.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white ">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Hanky/Napkins</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="hanky napkins.jpeg" alt="" width="100px" height="120px">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="border rounded pt-1 ">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Baby Toy Cleanners</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./bayb cleaners.jpeg" alt="" width="100px" height="120px">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
        </div>
        <div class="mb-5 d-flex ">
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Baby Toy Cleanners</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./bayb cleaners.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white ">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Animals & Birds</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./shoes.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="border rounded pt-1 ">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Hanky/Napkins</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="hanky napkins.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
        </div>
        <div class="line mt-3"></div>
        <p class="fs-6 fw-bold mt-3">Bachay Recommendation</p>
        <div class="mb-3 d-flex">
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Animals & Birds</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./shoes.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white ">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Hanky/Napkins</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./hanky napkins.jpeg" alt="" width="100px" height="120px">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="border rounded pt-1 ">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Baby Toy Cleanners</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./bayb cleaners.jpeg" alt="" width="100px" height="120px">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
        </div>
        <div class="mb-5 d-flex ">
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Baby Toy Cleanners</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./hanky napkins.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white ">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="image-box border rounded pt-1">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Animals & Birds</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="./shoes.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
            <div class="col-4">
                <div class="border rounded pt-1 ">
                    <div class="">
                        <p class="para-2 fw-bold text-center">Hanky/Napkins</p>
                    </div>
                    <div class="imge-1 ps-1 pe-1">
                        <img class="rounded" src="bayb cleaners.jpeg" alt="">
                    </div>
                    <div class="img-1 mt-2 text-center"> <span class="inner-text text-white">Viewed 112598</span></div>
                </div>
    
            </div>
        </div>
    </div>
    <div class="parenting pt-3 ps-3 pe-3">
        <div class="d-flex justify-content-between">
        <p class=" align-items-center fw-bold">Parenting Activities</p>
    
    <div>
        <img src="./down-arrrow.svg" alt="" width="16px" height="12px">
    </div>
    </div> 
    <div class="d-flex justify-content-between ps-2 pe-2 mt-3">
    <div class="d-flex align-items-center">
        <img src="./rank-img.png" alt="" width="40px" height="40px">
        
        <div>
            <p class="para-4 lh-1 ms-2 mb-0 fw-bold">Rank</p>
            <p class="para-3 ms-2 fw-bold mb-0">Gold</p>
        
        </div>
    </div>
    <div class="d-flex align-items-center">
        <img src="./badge-twel.png" alt="" width="40px" height="40px">
        
        <div>
            <p class="para-4 lh-1 ms-2 mb-0 fw-bold">Badge</p>
            <p class="para-3 ms-2 fw-bold mb-0">Twelve</p>
        
        </div>
    </div>
    <div class="d-flex align-items-center">
        <img src="./points.png" alt="" width="40px" height="40px">
        
        <div>
            <p class="para-4 lh-1 ms-2 mb-0 fw-bold">Points</p>
            <p class="para-3 ms-2 fw-bold mb-0">2163</p>
        
        </div>
    </div>
    </div>
    <div class="item-1 pb-3 mt-4 mb-4  ">
        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
    <div class="d-flex">
        <img class="me-2" src="./drafts.svg" alt="" width="20px" height="25px"> 
        <p class=" para-5 fw-bold">My Drafts</p>
    </div>
    <div class="img-2">
    <img src="./right-1.svg" alt="" width="22px" height="18px">
    </div>
    </a>
    </div>
    <div class="item-1 pb-3 mt-4 mb-4  ">
        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
        <div class="d-flex">
            <img class="me-2" src="./group.svg" alt="" width="20px" height="25px"> 
            <p class=" para-5 fw-bold">My Groups</p>
        </div>
        <div class="img-2">
        <img src="./right-1.svg" alt="" width="22px" height="18px">
        </div>
        </div>
        <div class="item-1 pb-3 mt-4 mb-4 ">
            <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
            <div class="d-flex">
                <img class="me-2" src="./question.svg" alt="" width="20px" height="25px"> 
                <p class=" para-5 fw-bold">My Questions</p>
            </div>
            <div class="img-2">
            <img src="./right-1.svg" alt="" width="22px" height="18px">
            </div>
        </a>
            </div>
            <div class="item-1 pb-3mt-4 mb-4  ">
                <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                <div class="d-flex">
                    <img class="me-2" src="./ANSWER.svg" alt="" width="20px" height="25px"> 
                    <p class=" para-5 fw-bold">My Answers</p>
                </div>
                <div class="img-2">
                <img src="./right-1.svg" alt="" width="22px" height="18px">
                </div>
            </a>
                </div>
                <div class="item-1 pb-3 mt-4 mb-4  ">
                    <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                    <div class="d-flex">
                        <img class="me-2" src="posts.svg" alt="" width="20px" height="25px"> 
                        <p class=" para-5 fw-bold">My Posts</p>
                    </div>
                    <div class="img-2">
                    <img src="./right-1.svg" alt="" width="22px" height="18px">
                    </div>
                </a>
                    </div>
                    <div class="item-1 pb-3 mt-4 mb-4  ">
                        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                        <div class="d-flex">
                            <img class="me-2" src="./earning.svg" alt="" width="20px" height="25px"> 
                            <p class=" para-5 fw-bold">My Earnings</p>
                        </div>
                        <div class="img-2">
                        <img src="./right-1.svg" alt="" width="22px" height="18px">
                        </div>
                    </a>
                        </div>
                        <div class="item-1 pb-3 mt-4 mb-4">
                            <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                            <div class="d-flex">
                                <img class="me-2" src="./contribu.svg" alt="" width="20px" height="25px"> 
                                <p class=" para-5 fw-bold">My Contributions</p>
                            </div>
                            <div class="img-2">
                            <img src="./right-1.svg" alt="" width="22px" height="18px">
                            </div>
                        </a>
                            </div>
                            <div class="item-1 pb-3 mt-4 mb-4  ">
                                <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                                <div class="d-flex">
                                    <img class="me-2" src="./memories.svg" alt="" width="20px" height="25px"> 
                                    <p class=" para-5 fw-bold">My Memories</p>
                                </div>
                                <div class="img-2">
                                <img src="./right-1.svg" alt="" width="22px" height="18px">
                                </div>
                            </a>
                                </div>
                                <div class="item-1 pb-3 mt-4 mb-4  ">
                                    <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                                    <div class="d-flex">
                                        <img class="me-2" src="./read.svg" alt="" width="20px" height="25px"> 
                                        <p class=" para-5 fw-bold">My Quick Reads</p>
                                    </div>
                                    <div class="img-2">
                                    <img src="./right-1.svg" alt="" width="22px" height="18px">
                                    </div>
                                </a>
                                    </div>
                                    <div class="item-1 pb-3 mt-4 mb-4">
                                        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                                        <div class="d-flex">
                                            <img class="me-2" src="./bumpie.svg" alt="" width="20px" height="25px"> 
                                            <p class=" para-5 fw-bold">My Bumpie</p>
                                        </div>
                                        <div class="img-2">
                                        <img src="./right-1.svg" alt="" width="22px" height="18px">
                                        </div>
                                    </a>
                                        </div>
                                        <div class="item-1 pb-3 mt-4 mb-4  ">
                                            <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                                            <div class="d-flex">
                                                <img class="me-2" src="./milestone.svg" alt="" width="20px" height="25px"> 
                                                <p class=" para-5 fw-bold">My Milestones</p>
                                            </div>
                                            <div class="img-2">
                                            <img src="./right-1.svg" alt="" width="22px" height="18px">
                                            </div>
                                        </a>
                                            </div>
                                            <div class="item-1  mb-4 ">
                                                <a class="d-flex justify-content-between  text-decoration-none text-dark" href="">
                                                <div class="d-flex">
                                                    <img class="me-2" src="./favoritw.svg" alt="" width="20px" height="25px"> 
                                                    <p class=" para-5 fw-bold">My Favorite Names</p>
                                                </div>
                                                <div class="img-2">
                                                <img src="./right-1.svg" alt="" width="22px" height="18px">
                                                </div>
                                            </a>
                                                </div>
                                                <div>
                                                    <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                                                    <div class="d-flex">
                                                        <img class="me-2" src="./bookmarks.svg" alt="" width="20px" height="25px"> 
                                                        <p class="text-decoration-none para-5 fw-bold">My Bookmarks</p>
                                                    </div>
                                                    <div class="img-2">
                                                    <img src="./right-1.svg" alt="" width="22px" height="18px">
                                                    </div>
                                                </a>
                                                    </div>
    </div>
    <div class="parenting pt-3 ps-3 pe-3 mt-3 mb-2">
        <div class="d-flex justify-content-between">
        <p class=" align-items-center fw-bold">Customer Service</p>
    
    <div>
        <img src="./down-arrrow.svg" alt="" width="16px" height="12px">
    </div>
    </div> 
    
    <div class="item-1 pb-3 mt-4 mb-4">
        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
    <div class="d-flex">
        <img class="me-2" src="./chat.svg" alt="" width="20px" height="25px"> 
        <p class=" para-6 fw-bold">Chat with Us</p>
    </div>
    <div class="img-2">
    <img src="./right-1.svg" alt="" width="22px" height="18px">
    </div>
    </a>
    </div>
    <div class="item-1 pb-3 mt-4 mb-4">
        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
        <div class="d-flex">
            <img class="me-2" src="./policies.svg" alt="" width="20px" height="25px"> 
            <p class=" para-5 fw-bold">Our Policies</p>
        </div>
        <div class="img-2">
        <img src="./right-1.svg" alt="" width="22px" height="18px">
        </div>
        <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
        </div>
        <div class="item-1 pb-3 mt-4 mb-4">
            <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
            <div class="d-flex">
                <img class="me-2" src="./support.svg" alt="" width="20px" height="25px"> 
                <p class=" para-5 fw-bold">Support</p>
            </div>
            <div class="img-2">
            <img src="./right-1.svg" alt="" width="22px" height="18px">
            </div>
            </a>
            </div>
            <div class="mt-4">
                <a class="d-flex justify-content-between text-decoration-none text-dark" href="">
                <div class="d-flex">
                    <img class="me-2" src="rate.svg" alt="" width="20px" height="25px"> 
                    <p class=" para-5 fw-bold">Rate the App</p>
                </div>
                <div class="img-2">
                <img src="./right-1.svg" alt="" width="22px" height="18px">
                </div>
                </a>
                </div>
               
    </div>
</body>
</html>