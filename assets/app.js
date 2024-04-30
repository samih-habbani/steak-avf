/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');


const $ = require('jquery');
require('bootstrap');

// jQuery code for liking a question
$('.like-button').click(function() {
    var questionId = $(this).data('question-id');
    var likeCountElement = $('.like-count');
    $('.like-button').toggleClass('d-none');
    $('.like-button-hidden').toggleClass('d-none disabled');
    $('.dislike-button').toggleClass('disabled');

    $.ajax({
        url: '/question/' + questionId + '/like',
        type: 'POST',
        success: function(response) {
            // Handle success, e.g., update the like count on the page
            likeCountElement.text(response.likeCount);
        }
    });
    return false; // Prevent default form submission
});

// jQuery code for disliking a question
$('.dislike-button').click(function() {
    var questionId = $(this).data('question-id');
    var likeCountElement = $('.like-count');
    $('.dislike-button').toggleClass('d-none');
    $('.dislike-button-hidden').toggleClass('d-none disabled');
    $('.like-button').toggleClass('disabled');
    $.ajax({
        url: '/question/' + questionId + '/dislike',
        type: 'POST',
        success: function(response) {
            // Handle success, e.g., update the like count on the page
            likeCountElement.text(response.likeCount);
        }
    });
    return false; // Prevent default form submission
});



// jQuery code for liking a answer
$('.like-button-answ').click(function() {
    var answerId = $(this).data('answer-id');
    var likeCountElementAnsw = $(this).next('div').find('.like-count-answ');
    $(this).prev('button').toggleClass('d-none disabled');
    $(this).toggleClass('d-none disabled');
    
    $.ajax({
        url: '/question/' + answerId + '/likeAnsw',
        type: 'POST',
        success: function(response) {
            // Handle success, e.g., update the like count on the page
            likeCountElementAnsw.text(response.likeCountAnsw);
            //location.reload(true); // NEEDS A CHANGE NEEDS A CHANGE NEEDS A CHANGE 
        }
    });
    return false; // Prevent default form submission
});

// jQuery code for disliking a answer
$('.dislike-button-answ').click(function() {
    var answerId = $(this).data('answer-id');
    var likeCountElementAnsw = $(this).prev('div').find('.like-count-answ');
    $(this).next('button').toggleClass('d-none disabled');
    $(this).toggleClass('d-none disabled');
    
    $.ajax({
        url: '/question/' + answerId + '/dislikeAnsw',
        type: 'POST',
        success: function(response) {
            // Handle success, e.g., update the like count on the page
            likeCountElementAnsw.text(response.likeCountAnsw);
            //location.reload(true); // NEEDS A CHANGE NEEDS A CHANGE NEEDS A CHANGE 
        }
    });
    return false; // Prevent default form submission
});




// Youtube INTEGRATION video

const loadVideo = (iframe) => {
    const cid = "UCee3DpFHYPezAlmnkLtPMRg";
    const channelURL = encodeURIComponent(`https://www.youtube.com/feeds/videos.xml?channel_id=${cid}`)
    const reqURL = `https://api.rss2json.com/v1/api.json?rss_url=${channelURL}`;
  
    fetch(reqURL)
        .then(response => response.json())
        .then(result => {
          console.log(result)
            const videoNumber = iframe.getAttribute('vnum')
            const link = result.items[videoNumber].link;
            const id = link.substr(link.indexOf("=") + 1);
            iframe.setAttribute("src", `https://youtube.com/embed/${id}?modestbranding=1&autohide=1&showinfo=0&controls=0`);
        })
        .catch(error => console.log('error', error));
  }
  
const iframes = document.getElementsByClassName('latestVideoEmbed');
  for (let i = 0, len = iframes.length; i < len; i++) {
    loadVideo(iframes[i]);
}




// Youtube INTEGRATION links

const loadTopRatedVideos = () => {
    const cid = "UCee3DpFHYPezAlmnkLtPMRg";
    const channelURL = encodeURIComponent(`https://www.youtube.com/feeds/videos.xml?channel_id=${cid}`)
    const reqURL = `https://api.rss2json.com/v1/api.json?rss_url=${channelURL}`;
  
    fetch(reqURL)
        .then(response => response.json())
        .then(result => {
            const videoList = document.getElementById('video-list');
            const items = result.items.slice(0, 3); // Limit to the top 3 videos.

            for (let i = 0; i < items.length; i++) {
                const videoNumber = i;
                const link = items[videoNumber].link;
                const title = items[videoNumber].title;

                // Create a link element
                const videoLink = document.createElement('a');
                videoLink.setAttribute('aria-label', 'Vidéos les mieux notées');
                videoLink.classList.add('text-decoration-none', 'text-secondary');
                videoLink.href = link;
                videoLink.target = '_blank';
                videoLink.textContent = title;

                // Create a div for the video link and append it to the videoList
                const videoDiv = document.createElement('div');
                videoDiv.classList.add('py-2');
                videoDiv.appendChild(videoLink);

                videoList.appendChild(videoDiv);
            }
        })
        .catch(error => console.log('error', error));
}

loadTopRatedVideos();





/////////// SELECTED CATEGORY FEATURE ///////////////////
document.addEventListener("DOMContentLoaded", function() {
    const categoryLinks = document.querySelectorAll(".category-link");
    const questionContainer = document.getElementById("question-container");
    

    categoryLinks.forEach(link => {
        link.addEventListener("click", function() {
            // Reset styling for all category links
            categoryLinks.forEach(link => {
                link.classList.remove("fw-bold", "opacity-100");
            });

            // Apply styling for the clicked category
            this.classList.add("fw-bold", "opacity-100");

            const categoryId = this.getAttribute("data-category-id");

            // AJAX
            fetch(`/questions?category_id=${categoryId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(data => {
                    questionContainer.innerHTML = data;
                });
        });
    });
});




///////// SEARCH BAR //////////////
$(document).ready(function() {
    $(".search-button").click(function() {
      $(".search-input").animate({ width: 'toggle' }, 300);
      $(this).toggleClass("expanded-button");
      $(this).toggleClass("d-none");
    });



    $("#search-content").on('keydown', function(e) {
        if(e.key === "Enter") {
            e.preventDefault();

              
            $.ajax({
                url:'/search',
                data: {
                    "search": $("#search-content").val()
                },
                dataType: 'json',
                success: function (data)
                {

                    let contentHtml = "";

                    contentHtml += "<h2 class='text-light fw-bold'> Résultat de recherche pour ' " + $("#search-content").val() + " ' </h2>";

                    for(let i = 0; i < data.length; i++) {
                        contentHtml += "<div class='d-flex shadow rounded mb-1'>"+
                                            "<a aria-label='" + data[i].title + "' class='d-flex text-decoration-none' href='/question/" + data[i].id + "'>"+
                                            
                                                "<div class='d-flex flex-column ps-2'>"+   
                                                    "<h2 class='text-secondary fw-bold'>" + data[i].title + " </h2>"+
                                                    "<p class='text-light opacity-75'>" + data[i].content  + " </p>"+
                                                "</div>"+
                                            "</a>"+
                                        "</div>";
                    }
                    
                    // dans la classe inner-content
                    // met le contenu
                    $(".inner-content").html(contentHtml);

                }
            });
        }
    });
});



$(document).ready(function() {
    $('.toggle-content-two').click(function() {
        $('.add-content-two').toggleClass('d-none d-block');
        $('.toggle-content-two').toggleClass('d-none d-block');
    });

    $('.toggle-code-two').click(function() {
        $('.add-code-two').toggleClass('d-none d-block');
        $('.toggle-code-two').toggleClass('d-none d-block');
    });

    $('.toggle-content-three').click(function() {
        $('.add-content-three').toggleClass('d-none d-block');
        $('.toggle-content-three').toggleClass('d-none d-block');
    });

    
    $('.toggle-code-three').click(function() {
        $('.add-code-three').toggleClass('d-none d-block');
        $('.toggle-code-three').toggleClass('d-none d-block');
    });

    
    $('.toggle-content-four').click(function() {
        $('.add-content-four').toggleClass('d-none d-block');
        $('.toggle-content-four').toggleClass('d-none d-block');
    });

    
    $('.toggle-code-four').click(function() {
        $('.add-code-four').toggleClass('d-none d-block');
        $('.toggle-code-four').toggleClass('d-none d-block');
    });
});




