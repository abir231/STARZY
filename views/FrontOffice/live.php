<?php
// views/live.php
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Site Metas -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../images/favicon.png" type="">

    <title>Starzy Chat</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- nice select  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
        integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
        crossorigin="anonymous" />
    <!-- font awesome style -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="../css/responsive.css" rel="stylesheet" />

    <style>


/* Modern Message reaction styles */
.message-reactions {
    display: flex;
    margin-top: 8px;
    justify-content: flex-end;
    gap: 8px;
}

.reaction-button {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    cursor: pointer;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 14px;
    transition: all 0.2s ease;
    color: #6c757d;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Style for user messages */
.message-user .reaction-button {
    background: rgba(240, 240, 240, 0.5);
}

/* Style for self messages */
.message-self .reaction-button {
    background: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.7);
}

.reaction-button:hover {
    transform: translateY(-2px);
    background: rgba(147, 112, 219, 0.2);
    color: #9370DB;
}

.message-self .reaction-button:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

.reaction-button.active {
    background: rgba(147, 112, 219, 0.3);
    color: #9370DB;
    font-weight: 500;
    transform: scale(1.05);
}

.message-self .reaction-button.active {
    background: rgba(255, 255, 255, 0.4);
    color: white;
    font-weight: 500;
}

.reaction-button i {
    margin-right: 5px;
    font-size: 15px;
}

.reaction-count {
    font-size: 13px;
    font-weight: 500;
    min-width: 15px;
    text-align: center;
}

/* TTS button style */
.tts-button {
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    cursor: pointer;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    transition: all 0.2s ease;
    color: #6c757d;
}

.message-self .tts-button {
    background: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.7);
}

.tts-button:hover {
    background: rgba(147, 112, 219, 0.2);
    color: #9370DB;
    transform: scale(1.1);
}

.message-self .tts-button:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}
body {
    background: url('../images/galaxy.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Arial', sans-serif;
}

.page-title {
    font-family: 'Brush Script MT', cursive;
    font-size: 3.5rem;
    color: white;
    text-align: center;
    margin-bottom: 30px;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.5), 0 0 20px rgba(147, 112, 219, 0.4);
}

#chat-window {
    height: 400px;
    overflow-y: auto;
    background-color: rgba(255, 255, 255, 0.85);
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(147, 112, 219, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
}

#messages {
    display: flex;
    flex-direction: column;
}

.message {
    margin-bottom: 10px;
    padding: 12px;
    border-radius: 18px;
    max-width: 80%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
}

.message-user {
    align-self: flex-start;
    background-color: #f0f0f0;
    border-bottom-left-radius: 5px;
}

.message-self {
    align-self: flex-end;
    background-color: #9370DB;
    color: white;
    border-bottom-right-radius: 5px;
}

.message-meta {
    font-size: 0.8em;
    color: #666;
    margin-bottom: 5px;
    display: flex;
    justify-content: space-between;
	padding-right: 60px; /* Add padding to prevent name from being hidden by buttons */

}

.message-self .message-meta {
    color: #e0e0e0;
}

/* Improved message actions */
.message-actions {
    display: none;
    position: absolute;
    right: 12px;
    top: 8px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    padding: 2px 8px;
    z-index: 10;
}

.message-self .message-actions {
    background-color: rgba(147, 112, 219, 0.8);
}

.message:hover .message-actions {
    display: flex;
}

.message-action-btn {
    background: none;
    border: none;
    color: #555;
    font-size: 14px;
    cursor: pointer;
    margin: 0 3px;
    padding: 2px 5px;
    transition: all 0.2s ease;
}

.message-self .message-action-btn {
    color: #ffffff;
}

.message-action-btn:hover {
    color: #9370DB;
    transform: scale(1.2);
}

.message-self .message-action-btn:hover {
    color: #ffffff;
    opacity: 0.8;
}

#recent-discussions {
    background-color: rgba(255, 255, 255, 0.85);
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(147, 112, 219, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
}

#recent-discussions h4 {
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
    border-bottom: 2px solid #9370DB;
    padding-bottom: 8px;
}

.discussion-item {
    border-radius: 10px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    border-left: 4px solid #9370DB;
    background-color: rgba(248, 249, 250, 0.7);
    cursor: pointer;
    position: relative;
    padding: 15px;
}

.discussion-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    background-color: rgba(233, 236, 239, 0.9);
}

/* Improved discussion actions */
.discussion-actions {
    display: none;
    position: absolute;
    right: 15px;
    top: 15px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    padding: 2px 8px;
    z-index: 5;
}

.discussion-item:hover .discussion-actions {
    display: flex;
}

.discussion-action-btn {
    background: none;
    border: none;
    color: #555;
    cursor: pointer;
    margin: 0 3px;
    padding: 2px 5px;
    font-size: 15px;
    transition: all 0.2s ease;
}

.discussion-action-btn:hover {
    transform: scale(1.2);
}

.discussion-action-btn.edit {
    color: #9370DB;
}

.discussion-action-btn.edit:hover {
    color: #7B68EE;
}

.discussion-action-btn.delete {
    color: #dc3545;
}

.discussion-action-btn.delete:hover {
    color: #c82333;
}

.discussion-item .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #9370DB;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.discussion-item .discussion-info {
    flex-grow: 1;
}

/* Black discussion name */
.discussion-name {
    color: #000000;
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 3px;
}

.discussion-item .discussion-date {
    font-size: 0.8em;
    color: #6c757d;
}

.chat-layout {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.chat-main {
    flex: 2;
    min-width: 300px;
}

.chat-sidebar {
    flex: 1;
    min-width: 250px;
}

#user-form {
    background-color: rgba(255, 255, 255, 0.85);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3), 0 0 15px rgba(147, 112, 219, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
}

.form-control {
    background-color: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(147, 112, 219, 0.3);
    border-radius: 20px;
    padding: 10px 15px;
}

.form-control:focus {
    border-color: #9370DB;
    box-shadow: 0 0 0 0.2rem rgba(147, 112, 219, 0.25);
}

.btn-primary, .btn-space {
    background-color: #9370DB;
    border-color: #9370DB;
    border-radius: 20px;
    padding: 8px 20px;
    transition: all 0.3s ease;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-primary:hover, .btn-space:hover {
    background-color: #8A65D7;
    border-color: #8A65D7;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.btn-new-chat {
    background: linear-gradient(45deg, #9370DB, #BA55D3);
    color: white;
    border: none;
    border-radius: 20px;
    padding: 10px 20px;
    margin-top: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(147, 112, 219, 0.4);
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.btn-new-chat i {
    margin-right: 8px;
}

.btn-new-chat:hover {
    background: linear-gradient(45deg, #8A65D7, #A349A4);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(147, 112, 219, 0.6);
}

#message-input-container {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    position: relative;
}

#message {
    border-radius: 20px;
    padding: 10px 15px;
    flex-grow: 1;
}

.modal-content {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-bottom: 2px solid #9370DB;
    padding: 15px 20px;
}

.modal-footer {
    border-top: none;
}

@media (max-width: 768px) {
    .chat-layout {
        flex-direction: column;
    }
    
    .page-title {
        font-size: 2.5rem;
    }
}

/* Stars animation */
.stars {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.star {
    position: absolute;
    background-color: white;
    border-radius: 50%;
    animation: twinkle 2s infinite alternate;
}

@keyframes twinkle {
    0% {
        opacity: 0.2;
    }
    100% {
        opacity: 0.8;
    }
}
.message-text {
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
    max-width: 100%;
}
#discussions-list {
    max-height: 300px;
    overflow-y: auto;
}
/* Updated to make the heading black */
#user-form h4 {
    color: #000000;
    font-weight: 600;
}
#editDiscussionModalLabel, 
#editDiscussionModal label {
    color: #000000;
    font-weight: 600;
}
#editMessageModalLabel{
	color:black;
}

#msgid {
	color:black;
}
#deleteConfirmModalLabel {
	color:black;
}
#delete-confirm-text {color:black;}

/* Emoji picker styles */
.emoji-button {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0 10px;
    transition: transform 0.2s;
    height: 38px;
    display: flex;
    align-items: center;
}

.emoji-button:hover {
    transform: scale(1.2);
}

.emoji-picker {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 300px;
    height: 250px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 1000;
    display: none;
    overflow-y: auto;
    padding: 10px;
}

.emoji-picker.show {
    display: block;
}

.emoji-categories {
    display: flex;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
    margin-bottom: 5px;
}

.emoji-category {
    cursor: pointer;
    padding: 5px;
    font-size: 1.2rem;
    transition: all 0.2s;
}

.emoji-category.active {
    color: #9370DB;
}

.emoji-category:hover {
    background-color: #f0f0f0;
    border-radius: 5px;
}

.emoji-container {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 5px;
}

.emoji {
    cursor: pointer;
    padding: 5px;
    text-align: center;
    font-size: 1.5rem;
    transition: transform 0.2s;
}

.emoji:hover {
    transform: scale(1.2);
    background-color: #f0f0f0;
    border-radius: 5px;
}

/* Voice message styles */
.voice-record-button {
    background: none;
    border: none;
    color: #9370DB;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 5px 10px;
    transition: all 0.2s;
    position: relative;
    height: 38px;
    display: flex;
    align-items: center;
}

.voice-record-button:hover {
    transform: scale(1.1);
}

.voice-record-button.recording {
    color: #dc3545;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

.voice-record-timer {
    position: absolute;
    bottom: -20px;
    left: 0;
    font-size: 12px;
    color: #dc3545;
    display: none;
}

.voice-record-timer.show {
    display: block;
}

.input-group-prepend.message-input-buttons {
    display: flex;
    align-items: center;
    height: 38px;
}

/* Enhanced audio player styling */
.audio-message {
    width: 100%;
    height: 40px;
    margin-top: 5px;
    outline: none;
    border-radius: 20px;
    background-color: rgba(255, 255, 255, 0.2);
}

/* For self messages */
.message-self .audio-message {
    background-color: rgba(255, 255, 255, 0.3);
}

/* Improved audio controls */
audio::-webkit-media-controls-panel {
    background-color: rgba(147, 112, 219, 0.2);
}

audio::-webkit-media-controls-play-button {
    background-color: rgba(147, 112, 219, 0.4);
    border-radius: 50%;
}

/* Message reaction styles */
.message-reactions {
    display: flex;
    margin-top: 5px;
    justify-content: flex-end;
}

.reaction-button {
    background: none;
    border: none;
    cursor: pointer;
    margin-left: 10px;
    padding: 2px 5px;
    border-radius: 15px;
    font-size: 14px;
    transition: all 0.2s;
    color: #6c757d;
}

.reaction-button:hover {
    background-color: rgba(147, 112, 219, 0.1);
}

.reaction-button.active {
    background-color: rgba(147, 112, 219, 0.2);
    color: #9370DB;
}

.reaction-button i {
    margin-right: 3px;
}

.reaction-count {
    font-size: 12px;
}

/* TTS button style */
.tts-button {
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.2s;
    padding: 2px 5px;
    border-radius: 15px;
}

.tts-button:hover {
    color: #9370DB;
    background-color: rgba(147, 112, 219, 0.1);
}

/* Search styles */
#search-discussions {
    position: relative;
    margin-bottom: 10px;
}

.search-no-result {
    font-style: italic;
    color: #6c757d;
    text-align: center;
    padding: 10px;
}

.form-control.is-invalid {
    border-color: #dc3545;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.btn-primary.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
    </style>
</head>

<body class="sub_page">
    <!-- Stars background animation -->
    <div class="stars" id="stars"></div>

    <div class="hero_area">
        <!-- header section starts -->
<header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="designe.php">
            <span>
              STARZY
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item ">
                <a class="nav-link" href="designe.php">Home </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="products.php">Menu</a>
              </li>
			                <li class="nav-item">
                <a class="nav-link" href="ordernow.php">order now</a>
              </li>
			    <li class="nav-item active">
                <a class="nav-link" href="live.php">Live Chat <span class="sr-only">(current)</span> </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About </a>
              </li>

			  
            </ul>
            <div class="user_option">
              <a href="" class="user_link">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              <a class="cart_link" href="#">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                  <g>
                    <g>
                      <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                   c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                   C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                   c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                   C457.728,97.71,450.56,86.958,439.296,84.91z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                   c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                    </g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                </svg>
              </a>
              <form class="form-inline">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
              <a href="" class="order_online">
                Order Online
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
        <!-- header section ends -->
    </div>

    <main>
        <section id="chat-space" class="layout_padding">
            <div class="container">
                <h1 class="page-title">Live Chat</h1>
                
                <div class="chat-layout">
                    <div class="chat-main">
                        <div id="user-form" class="mb-4">
                            <h4><i class="fa fa-comment-o"></i> Start a new conversation</h4>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" id="username" class="form-control" placeholder="Enter your username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button id="start-chat" class="btn btn-primary w-100">Start Chatting</button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="chat-container" style="display: none;">
                            <div id="chat-window">
                                <div id="messages"></div>
                            </div>
                            <div id="chat-input">
                                <div id="message-input-container">
                                    <div class="input-group">
                                        <div class="input-group-prepend message-input-buttons">
                                            <button class="emoji-button" id="emoji-button" title="Add emoji">
                                                <i class="fa fa-smile-o"></i>
                                            </button>
                                            <button class="voice-record-button" id="voice-record-button" title="Record voice message">
                                                <i class="fa fa-microphone"></i>
                                                <span class="voice-record-timer" id="voice-record-timer">0:00</span>
                                            </button>
                                        </div>
                                        <input type="text" id="message" class="form-control" placeholder="Type your message...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="send-button"><i class="fa fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                    
                                    <!-- Emoji picker -->
                                    <div class="emoji-picker" id="emoji-picker">
                                        <div class="emoji-categories">
                                            <div class="emoji-category active" data-category="smileys">😀</div>
                                            <div class="emoji-category" data-category="people">👨</div>
                                            <div class="emoji-category" data-category="animals">🐶</div>
                                            <div class="emoji-category" data-category="food">🍎</div>
                                            <div class="emoji-category" data-category="travel">🚗</div>
                                            <div class="emoji-category" data-category="activities">⚽</div>
                                            <div class="emoji-category" data-category="objects">💡</div>
                                            <div class="emoji-category" data-category="symbols">❤️</div>
                                        </div>
                                        <div class="emoji-container" id="emoji-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="chat-sidebar">
                        <div id="recent-discussions" class="mb-4">
                            <h4><i class="fa fa-comments"></i> Recent Chats</h4>
                            
                            <!-- Search input for discussions -->
                            <div class="input-group mb-3" id="search-discussions">
                                <input type="text" class="form-control" id="discussion-search-input" placeholder="Search discussions...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div id="discussions-list">
                                <!-- Discussion items will be loaded here dynamically -->
                            </div>
                            <button id="new-chat-btn" class="btn-new-chat mt-3"><i class="fa fa-plus-circle"></i> Start New Chat</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Edit Message Modal -->
    <div class="modal fade" id="editMessageModal" tabindex="-1" role="dialog" aria-labelledby="editMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMessageModalLabel">Edit Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label id="msgid" for="edit-message-text">Message</label>
                        <textarea class="form-control" id="edit-message-text" rows="3"></textarea>
                        <input type="hidden" id="edit-message-id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-message-edit">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Discussion Modal -->
    <div class="modal fade" id="editDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="editDiscussionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDiscussionModalLabel">Edit Chat Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-discussion-name">Chat Name</label>
                        <input type="text" class="form-control" id="edit-discussion-name">
                        <input type="hidden" id="edit-discussion-id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-discussion-edit">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="delete-confirm-text">Are you sure you want to delete this item?</p>
                    <input type="hidden" id="delete-item-id">
                    <input type="hidden" id="delete-item-type">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- footer section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>Contact Us</h4>
                        <div class="contact_link_box">
                            <a href="">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>Location</span>
                            </a>
                            <a href="">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>Call +01 1234567890</span>
                            </a>
                            <a href="">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>demo@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <div class="footer_detail">
                        <a href="" class="footer-logo">STARZY</a>
                        <p>Necessary, making this the first true generator on the Internet. It uses a dictionary of over
                            200 Latin words, combined with</p>
                        <div class="footer_social">
                            <a href="">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-pinterest" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>Opening Hours</h4>
                    <p>Everyday</p>
                    <p>10.00 Am -10.00 Pm</p>
                </div>
            </div>
            <div class="footer-info">
                <p>&copy; <span id="displayYear"></span> All Rights Reserved By <a href="https://html.design/">Free Html
                     Templates</a><br><br>&copy; <span id="displayYear"></span> Distributed By <a 
                     href="https://themewagon.com/" target="_blank">ThemeWagon</a></p>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="../js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <!-- bootstrap js -->
    <script src="../js/bootstrap.js"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <!-- custom js -->
    <script src="../js/custom.js"></script>
    
    <!-- Chat JavaScript -->
    <script>
        $(document).ready(function() {
    // Global variables
    let currentDiscussionId = null;
    let currentUserId = Math.floor(Math.random() * 10000); // Simulating user ID
    let messagePollingInterval = null;
    
    // Global variables for new features
    let isRecording = false;
    let mediaRecorder = null;
    let audioChunks = [];
    let recordingTimer = null;
    let recordingDuration = 0;
    let speechSynthesis = window.speechSynthesis;
    
    // Create stars for the background animation
    createStars();
    
    // Initialize emoji picker
    initEmojiPicker();
    
    // Load recent discussions when page loads
    loadRecentDiscussions();
    // Refresh discussions periodically
    setInterval(loadRecentDiscussions, 10000);
    
    // Toggle emoji picker
    $('#emoji-button').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#emoji-picker').toggleClass('show');
    });
    
    // Close emoji picker when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('#emoji-picker, #emoji-button').length) {
            $('#emoji-picker').removeClass('show');
        }
    });
    
    // Initialize voice recording
    $('#voice-record-button').click(function(e) {
        e.preventDefault();
        if (!isRecording) {
            startRecording();
        } else {
            stopRecording();
        }
    });
    
    // Start new chat button
    $('#new-chat-btn').click(function() {
        // Hide chat container if visible
        $('#chat-container').hide();
        // Show user form
        $('#user-form').show();
        // Clear current discussion ID
        currentDiscussionId = null;
        // Clear the username field
        $('#username').val('');
        // Stop message polling
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
            messagePollingInterval = null;
        }
    });
    
    // Start chat button click
    $('#start-chat').click(function() {
        const username = $('#username').val().trim();
        if (username === '') {
            alert('Please enter a username');
            return;
        }
        
        // Create a new discussion
        $.ajax({
            url: '../../controllers/LiveController.php?action=createDiscussion',
            method: 'POST',
            data: { 
                nom_user: username,
                user_id: currentUserId
            },
            success: function(response) {
                if (response.status === 'success') {
                    currentDiscussionId = response.discussion_id;
                    
                    // Show chat container
                    $('#user-form').hide();
                    $('#chat-container').show();
                    
                    // Refresh the discussions list
                    loadRecentDiscussions();
                    
                    // Start polling for messages
                    loadMessages();
                    messagePollingInterval = setInterval(loadMessages, 3000);
                } else {
                    alert('Error creating chat: ' + response.message);
                }
            },
            error: function() {
                alert('Error connecting to server');
            }
        });
    });
    
    // Add discussion search functionality
    $('#discussion-search-input').on('input', function() {
        const searchTerm = $(this).val().toLowerCase().trim();
        if (searchTerm === '') {
            $('.discussion-item').show();
            $('.search-no-result').remove();
            return;
        }
        
        let hasVisibleItems = false;
        $('.discussion-item').each(function() {
            const discussionName = $(this).find('.discussion-name').text().toLowerCase();
            if (discussionName.includes(searchTerm)) {
                $(this).show();
                hasVisibleItems = true;
            } else {
                $(this).hide();
            }
        });
        
        // Show "no results" message if needed
        if ($('.search-no-result').length === 0 && !hasVisibleItems) {
            $('#discussions-list').append('<div class="search-no-result">No discussions found</div>');
        } else if (hasVisibleItems) {
            $('.search-no-result').remove();
        }
    });
    
    // Send message button click
    $('#send-button').click(sendMessage);
    
    // Also send on Enter key press
    $('#message').keypress(function(e) {
        if (e.which === 13) {
            sendMessage();
        }
    });
    
    // Empty check for message sending with visual feedback
    $('#message').on('keyup', function() {
        if ($(this).val().trim() === '') {
            $('#send-button').addClass('disabled');
        } else {
            $('#send-button').removeClass('disabled');
        }
    });
    
    // Enhanced function to send a message
    function sendMessage() {
        const messageText = $('#message').val().trim();
        if (messageText === '' && !audioChunks.length && !currentDiscussionId) {
            // If message is empty and no audio is recorded, do nothing
            return;
        }
        
        if (currentDiscussionId) {
            if (audioChunks.length > 0) {
                // Send voice message
                sendVoiceMessage();
            } else if (messageText !== '') {
                // Send text message
                $.ajax({
                    url: '../../controllers/LiveController.php?action=sendMessage',
                    method: 'POST',
                    data: {
                        discussion_id: currentDiscussionId,
                        message: messageText,
                        user_id: currentUserId  // Include current user ID
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Clear input field
                            $('#message').val('');
                            // Load the new message
                            loadMessages();
                            // Refresh discussions list to show most recent activity
                            loadRecentDiscussions();
                        } else {
                            alert('Error sending message: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error connecting to server');
                    }
                });
            } else {
                // Alert for empty message
                const messageInput = $('#message');
                messageInput.addClass('is-invalid');
                setTimeout(function() {
                    messageInput.removeClass('is-invalid');
                }, 2000);
            }
        }
    }
    
    // Function to load messages with reactions and TTS buttons
    function loadMessages() {
        if (!currentDiscussionId) return;
        
        $.ajax({
            url: '../../controllers/LiveController.php?action=getMessages',
            method: 'GET',
            data: { 
                discussion_id: currentDiscussionId,
                current_user_id: currentUserId // Pass this to help server identify user's messages
            },
            success: function(messages) {
                $('#messages').empty();
                
                // Restore audio elements from session storage
                restoreAudioElements();
                
                messages.forEach(function(message) {
                    // For testing: force all messages to be "self" messages
                    // In production, uncomment the real check below
                    const isSelf = true; // message.user_id == currentUserId;
                    const messageClass = isSelf ? 'message-self' : 'message-user';
                    
                    // Format date
                    const messageDate = new Date(message.date_envoi);
                    const formattedDate = messageDate.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    // Get reaction counts
                    const likeCount = message.reactions ? message.reactions.like : 0;
                    const dislikeCount = message.reactions ? message.reactions.dislike : 0;
                    
                    // Get user reaction if any
                    const userReaction = message.user_reaction;
                    const likeActive = userReaction === 'like' ? 'active' : '';
                    const dislikeActive = userReaction === 'dislike' ? 'active' : '';
                    
                    // Only show edit/delete buttons for own messages (currently showing for all)
                    const actionButtons = isSelf ? `
                        <div class="message-actions">
                            <button class="message-action-btn edit-message" data-id="${message.id_message}">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="message-action-btn delete-message" data-id="${message.id_message}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ` : '';
                    
                    // Check if message contains audio
                    const hasAudio = message.raw_message.includes('<audio');
                    
                    // Add reaction buttons and text-to-speech button
                    const reactionButtons = `
                        <div class="message-reactions">
                            <button class="reaction-button like-button ${likeActive}" data-id="${message.id_message}">
                                <i class="fa fa-thumbs-up"></i> <span class="reaction-count">${likeCount}</span>
                            </button>
                            <button class="reaction-button dislike-button ${dislikeActive}" data-id="${message.id_message}">
                                <i class="fa fa-thumbs-down"></i> <span class="reaction-count">${dislikeCount}</span>
                            </button>
                            ${!hasAudio ? `<button class="tts-button" data-id="${message.id_message}" title="Listen to this message">
                                <i class="fa fa-volume-up"></i>
                            </button>` : ''}
                        </div>
                    `;
                    
                    const messageHtml = `
                        <div class="message ${messageClass}" data-id="${message.id_message}">
                            ${actionButtons}
                            <div class="message-meta">
                                <strong>${message.nom_user}</strong> • ${formattedDate}
                            </div>
                            <div class="message-text">
                                ${message.raw_message}
                            </div>
                            ${reactionButtons}
                        </div>
                    `;
                    
                    $('#messages').append(messageHtml);
                });
                
                // Add event handlers for edit and delete buttons
                $('.edit-message').off('click').on('click', function() {
                    const messageId = $(this).data('id');
                    const messageText = $(this).closest('.message').find('.message-text').text().trim();
                    openEditMessageModal(messageId, messageText);
                });
                
                $('.delete-message').off('click').on('click', function() {
                    const messageId = $(this).data('id');
                    openDeleteConfirmModal('message', messageId, 'Are you sure you want to delete this message?');
                });
                
                // Updated reaction handler
                $('.like-button, .dislike-button').off('click').on('click', function() {
                    const messageId = $(this).data('id');
                    const isLike = $(this).hasClass('like-button');
                    const button = $(this);
                    
                    // Toggle active state
                    if (button.hasClass('active')) {
                        // Remove reaction
                        $.ajax({
                            url: '../../controllers/LiveController.php?action=removeReaction',
                            method: 'POST',
                            data: {
                                message_id: messageId,
                                user_id: currentUserId
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    button.removeClass('active');
                                    let count = parseInt(button.find('.reaction-count').text()) - 1;
                                    button.find('.reaction-count').text(count > 0 ? count : 0);
                                }
                            }
                        });
                    } else {
                        // Add reaction
                        $.ajax({
                            url: '../../controllers/LiveController.php?action=addReaction',
                            method: 'POST',
                            data: {
                                message_id: messageId,
                                user_id: currentUserId,
                                reaction_type: isLike ? 'like' : 'dislike'
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    button.addClass('active');
                                    button.find('.reaction-count').text(parseInt(button.find('.reaction-count').text()) + 1);
                                    
                                    // Remove active state from other button
                                    const otherButton = isLike ? 
                                        button.siblings('.dislike-button') : 
                                        button.siblings('.like-button');
                                    
                                    if (otherButton.hasClass('active')) {
                                        otherButton.removeClass('active');
                                        let count = parseInt(otherButton.find('.reaction-count').text()) - 1;
                                        otherButton.find('.reaction-count').text(count > 0 ? count : 0);
                                    }
                                }
                            }
                        });
                    }
                });
                
                // Add event handlers for text-to-speech
                $('.tts-button').off('click').on('click', function() {
                    const messageId = $(this).data('id');
                    const messageText = $(this).closest('.message').find('.message-text').text().trim();
                    
                    // Use the browser's speech synthesis API
                    if (speechSynthesis) {
                        // Cancel any ongoing speech
                        speechSynthesis.cancel();
                        
                        const utterance = new SpeechSynthesisUtterance(messageText);
                        utterance.lang = 'en-US';
                        speechSynthesis.speak(utterance);
                    } else {
                        alert('Your browser does not support text-to-speech.');
                    }
                });
                
                // Scroll to bottom
                const chatWindow = document.getElementById('chat-window');
                chatWindow.scrollTop = chatWindow.scrollHeight;
            },
            error: function() {
                console.error('Error loading messages');
            }
        });
    }
    
    // Function to restore audio elements from session storage
    function restoreAudioElements() {
        setTimeout(function() {
            $('audio').each(function() {
                const audioKey = $(this).data('key');
                if (audioKey && sessionStorage.getItem(audioKey)) {
                    const audioUrl = sessionStorage.getItem(audioKey);
                    $(this).find('source').attr('src', audioUrl);
                    this.load(); // Reload the audio element to use the new source
                }
            });
        }, 500);
    }
    
    // Function to load recent discussions
    function loadRecentDiscussions() {
        $.ajax({
            url: '../../controllers/LiveController.php?action=getDiscussions',
            method: 'GET',
            success: function(discussions) {
                $('#discussions-list').empty();
                if (discussions.length === 0) {
                    $('#discussions-list').html('<p class="text-muted">No recent chats found.</p>');
                    return;
                }
                
                discussions.forEach(function(discussion) {
                    const discussionDate = new Date(discussion.creation_date);
                    const formattedDate = discussionDate.toLocaleString([], {
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    const initials = discussion.nom_user.split(' ').map(word => word[0]).join('').toUpperCase();
                    
                    const isActive = discussion.id_dis == currentDiscussionId;
                    const activeClass = isActive ? 'active bg-light' : '';
                    
                    const discussionHtml = `
                        <div class="discussion-item p-3 mb-2 ${activeClass}" data-id="${discussion.id_dis}">
                            <div class="discussion-actions">
                                <button class="discussion-action-btn edit edit-discussion" data-id="${discussion.id_dis}" data-name="${discussion.nom_user}">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button class="discussion-action-btn delete delete-discussion" data-id="${discussion.id_dis}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar">${initials}</div>
                                <div class="discussion-info">
                                    <div class="discussion-name">${discussion.nom_user}</div>
                                    <div class="discussion-date">${formattedDate}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#discussions-list').append(discussionHtml);
                });
                
                // Add click event for joining existing discussions
                $('.discussion-item').off('click').on('click', function(e) {
                    // Only proceed if the click was not on an action button
                    if (!$(e.target).closest('.discussion-actions').length) {
                        const discussionId = $(this).data('id');
                        // Don't reload if already in this discussion
                        if (currentDiscussionId === discussionId) return;
                        
                        currentDiscussionId = discussionId;
                        
                        // Set this discussion as active
                        $('.discussion-item').removeClass('active bg-light');
                        $(this).addClass('active bg-light');
                        
                        // Show chat container
                        $('#user-form').hide();
                        $('#chat-container').show();
                        
                        // Clear existing interval
                        if (messagePollingInterval) {
                            clearInterval(messagePollingInterval);
                        }
                        
                        // Start polling for messages
                        loadMessages();
                        messagePollingInterval = setInterval(loadMessages, 3000);
                    }
                });
                
                // Add event handlers for edit and delete discussion buttons
                $('.edit-discussion').off('click').on('click', function(e) {
                    e.stopPropagation(); // Prevent discussion selection
                    const discussionId = $(this).data('id');
                    const discussionName = $(this).data('name');
                    openEditDiscussionModal(discussionId, discussionName);
                });
                
                $('.delete-discussion').off('click').on('click', function(e) {
                    e.stopPropagation(); // Prevent discussion selection
                    const discussionId = $(this).data('id');
                    openDeleteConfirmModal('discussion', discussionId, 'Are you sure you want to delete this chat? All messages will be permanently deleted.');
                });
                
                // Reapply search filter if it was active
                const searchTerm = $('#discussion-search-input').val().trim();
                if (searchTerm !== '') {
                    $('#discussion-search-input').trigger('input');
                }
            },
            error: function() {
                console.error('Error loading discussions');
            }
        });
    }
    
    // Function to open edit message modal
    function openEditMessageModal(messageId, messageText) {
        $('#edit-message-id').val(messageId);
        $('#edit-message-text').val(messageText);
        $('#editMessageModal').modal('show');
    }
    
    // Function to open edit discussion modal
    function openEditDiscussionModal(discussionId, discussionName) {
        $('#edit-discussion-id').val(discussionId);
        $('#edit-discussion-name').val(discussionName);
        $('#editDiscussionModal').modal('show');
    }
    
    // Function to open delete confirmation modal
    function openDeleteConfirmModal(itemType, itemId, confirmText) {
        $('#delete-item-type').val(itemType);
        $('#delete-item-id').val(itemId);
        $('#delete-confirm-text').text(confirmText);
        $('#deleteConfirmModal').modal('show');
    }
    
    // Save edited message
    $('#save-message-edit').click(function() {
        const messageId = $('#edit-message-id').val();
        const newText = $('#edit-message-text').val().trim();
        
        if (!newText) {
            alert('Message cannot be empty');
            return;
        }
        
        $.ajax({
            url: '../../controllers/LiveController.php?action=updateMessage',
            method: 'POST',
            data: {
                message_id: messageId,
                new_text: newText
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#editMessageModal').modal('hide');
                    loadMessages();
                } else {
                    alert('Error updating message: ' + response.message);
                }
            },
            error: function() {
                alert('Error connecting to server');
            }
        });
    });
    
    // Save edited discussion name
    $('#save-discussion-edit').click(function() {
        const discussionId = $('#edit-discussion-id').val();
        const newName = $('#edit-discussion-name').val().trim();
        
        if (!newName) {
            alert('Chat name cannot be empty');
            return;
        }
        
        $.ajax({
            url: '../../controllers/LiveController.php?action=updateDiscussionName',
            method: 'POST',
            data: {
                discussion_id: discussionId,
                new_name: newName
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#editDiscussionModal').modal('hide');
                    loadRecentDiscussions();
                    // Also reload messages to update the username in the message headers
                    if (currentDiscussionId === discussionId) {
                        loadMessages();
                    }
                } else {
                    alert('Error updating chat name: ' + response.message);
                }
            },
            error: function() {
                alert('Error connecting to server');
            }
        });
    });
    
    // Confirm delete
    $('#confirm-delete').click(function() {
        const itemType = $('#delete-item-type').val();
        const itemId = $('#delete-item-id').val();
        
        let url, data;
        
        if (itemType === 'message') {
            url = '../../controllers/LiveController.php?action=deleteMessage';
            data = { message_id: itemId };
        } else if (itemType === 'discussion') {
            url = '../../controllers/LiveController.php?action=deleteDiscussion';
            data = { discussion_id: itemId };
        } else {
            alert('Invalid item type');
            return;
        }
        
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    $('#deleteConfirmModal').modal('hide');
                    
                    if (itemType === 'message') {
                        loadMessages();
                    } else if (itemType === 'discussion') {
                        // If the current discussion was deleted, go back to the form
                        if (currentDiscussionId === itemId) {
                            currentDiscussionId = null;
                            $('#chat-container').hide();
                            $('#user-form').show();
                            
                            if (messagePollingInterval) {
                                clearInterval(messagePollingInterval);
                                messagePollingInterval = null;
                            }
                        }
                        loadRecentDiscussions();
                    }
                } else {
                    alert('Error deleting ' + itemType + ': ' + response.message);
                }
            },
            error: function() {
                alert('Error connecting to server');
            }
        });
    });
    
    // Initialize emoji picker
    function initEmojiPicker() {
        const emojis = {
            'smileys': ['😀', '😁', '😂', '🤣', '😃', '😄', '😅', '😆', '😉', '😊', '😋', '😎', '😍', '😘', '😗', '😙', '😚', '🙂', '🤔', '😐', '😑', '😶', '🙄', '😏', '😣', '😥', '😮', '🤐', '😯', '😪', '😫', '😴', '😌', '😛', '😜', '😝', '🤤', '😒', '😓', '😔', '😕', '🙃', '🤑', '😲', '☹️', '🙁', '😖', '😞', '😟', '😤', '😢', '😭', '😦', '😧', '😨', '😩', '😬', '😰', '😱', '😳', '😵', '😡', '😠', '😷', '🤒', '🤕', '🤢', '🤧', '😇', '🤠', '🤡', '🤥', '🤓', '😈', '👿', '👹', '👺', '💀', '👻', '👽', '🤖', '💩', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'],
            'people': ['👶', '👦', '👧', '👨', '👩', '👴', '👵', '👲', '👳‍♀️', '👳‍♂️', '👮‍♀️', '👮‍♂️', '👷‍♀️', '👷‍♂️', '💂‍♀️', '💂‍♂️', '🕵️‍♀️', '🕵️‍♂️', '👩‍⚕️', '👨‍⚕️', '👩‍🌾', '👨‍🌾', '👩‍🍳', '👨‍🍳', '👩‍🎓', '👨‍🎓', '👩‍🎤', '👨‍🎤', '👩‍🏫', '👨‍🏫', '👩‍🏭', '👨‍🏭', '👩‍💻', '👨‍💻', '👩‍💼', '👨‍💼', '👩‍🔧', '👨‍🔧', '👩‍🔬', '👨‍🔬', '👩‍🎨', '👨‍🎨', '👩‍🚒', '👨‍🚒', '👩‍✈️', '👨‍✈️', '👩‍🚀', '👨‍🚀', '👩‍⚖️', '👨‍⚖️', '🤶', '🎅', '👸', '🤴', '👰', '🤵', '👼', '🤰', '🙇‍♀️', '🙇‍♂️', '💁‍♀️', '💁‍♂️', '🙅‍♀️', '🙅‍♂️', '🙆‍♀️', '🙆‍♂️', '🙋‍♀️', '🙋‍♂️', '🤦‍♀️', '🤦‍♂️', '🤷‍♀️', '🤷‍♂️', '💆‍♀️', '💆‍♂️', '💇‍♀️', '💇‍♂️', '🚶‍♀️', '🚶‍♂️', '🏃‍♀️', '🏃‍♂️', '💃', '🕺', '👯‍♀️', '👯‍♂️', '🕴', '🗣', '👤', '👥', '👫', '👬', '👭', '💏', '💑', '👪', '👨‍👩‍👧', '👨‍👩‍👧‍👦', '👨‍👩‍👦‍👦', '👨‍👩‍👧‍👧', '👨‍👨‍👦', '👨‍👨‍👧', '👨‍👨‍👧‍👦', '👨‍👨‍👦‍👦', '👨‍👨‍👧‍👧', '👩‍👩‍👦', '👩‍👩‍👧', '👩‍👩‍👧‍👦', '👩‍👩‍👦‍👦', '👩‍👩‍👧‍👧', '👨‍👦', '👨‍👦‍👦', '👨‍👧', '👨‍👧‍👦', '👨‍👧‍👧', '👩‍👦', '👩‍👦‍👦', '👩‍👧', '👩‍👧‍👦', '👩‍👧‍👧'],
            'animals': ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🐛', '🦋', '🐌', '🐚', '🐞', '🐜', '🕷', '🕸', '🐢', '🐍', '🦎', '🦂', '🦀', '🦑', '🐙', '🦐', '🐠', '🐟', '🐡', '🐬', '🦈', '🐳', '🐋', '🐊', '🐆', '🐅', '🐃', '🐂', '🐄', '🦌', '🐪', '🐫', '🐘', '🦏', '🦍', '🐎', '🐖', '🐐', '🐏', '🐑', '🐕', '🐩', '🐈', '🐓', '🦃', '🕊', '🐇', '🐁', '🐀', '🐿', '🐾', '🐉', '🐲', '🌵', '🎄', '🌲', '🌳', '🌴', '🌱', '🌿', '☘️', '🍀', '🎍', '🎋', '🍃', '🍂', '🍁', '🍄', '🌾', '💐', '🌷', '🌹', '🥀', '🌻', '🌼', '🌸', '🌺', '🌎', '🌍', '🌏', '🌕', '🌖', '🌗', '🌘', '🌑', '🌒', '🌓', '🌔', '🌚', '🌝', '🌞', '🌛', '🌜', '🌙', '💫', '⭐️', '🌟', '✨', '⚡️', '🔥', '💥', '☄', '☀️', '🌤', '⛅️', '🌥', '🌦', '🌈', '☁️', '🌧', '⛈', '🌩', '🌨', '☃️', '⛄️', '❄️', '🌬', '💨', '🌪', '🌫', '🌊', '💧', '💦', '☔️'],
            'food': ['🍏', '🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🍈', '🍒', '🍑', '🍍', '🥝', '🥑', '🍅', '🍆', '🥒', '🥕', '🌽', '🌶', '🥔', '🍠', '🌰', '🥜', '🍯', '🥐', '🍞', '🥖', '🧀', '🥚', '🍳', '🥓', '🥞', '🍤', '🍗', '🍖', '🍕', '🌭', '🍔', '🍟', '🥙', '🌮', '🌯', '🥗', '🥘', '🍝', '🍜', '🍲', '🍥', '🍣', '🍱', '🍛', '🍚', '🍙', '🍘', '🍢', '🍡', '🍧', '🍨', '🍦', '🍰', '🎂', '🍮', '🍭', '🍬', '🍫', '🍿', '🍩', '🍪', '🥛', '🍼', '☕️', '🍵', '🍶', '🍺', '🍻', '🥂', '🍷', '🥃', '🍸', '🍹', '🍾', '🥄', '🍴', '🍽'],
            'travel': ['🚗', '🚕', '🚙', '🚌', '🚎', '🏎', '🚓', '🚑', '🚒', '🚐', '🚚', '🚛', '🚜', '🛴', '🚲', '🛵', '🏍', '🚨', '🚔', '🚍', '🚘', '🚖', '🚡', '🚠', '🚟', '🚃', '🚋', '🚞', '🚝', '🚄', '🚅', '🚈', '🚂', '🚆', '🚇', '🚊', '🚉', '🚁', '🛩', '✈️', '🛫', '🛬', '🚀', '🛰', '💺', '🛶', '⛵️', '🛥', '🚤', '🛳', '⛴', '🚢', '⚓️', '🚧', '⛽️', '🚏', '🚦', '🚥', '🗺', '🗿', '🗽', '⛲️', '🗼', '🏰', '🏯', '🏟', '🎡', '🎢', '🎠', '⛱', '🏖', '🏝', '⛰', '🏔', '🗻', '🌋', '🏜', '🏕', '⛺️', '🛤', '🛣', '🏗', '🏭', '🏠', '🏡', '🏘', '🏚', '🏢', '🏬', '🏣', '🏤', '🏥', '🏦', '🏨', '🏪', '🏫', '🏩', '💒', '🏛', '⛪️', '🕌', '🕍', '🕋', '⛩', '🗾', '🎑', '🏞', '🌅', '🌄', '🌠', '🎇', '🎆', '🌇', '🌆', '🏙', '🌃', '🌌', '🌉', '🌁'],
            'activities': ['⚽️', '🏀', '🏈', '⚾️', '🎾', '🏐', '🏉', '🎱', '🏓', '🏸', '🥅', '🏒', '🏑', '🏏', '⛳️', '🏹', '🎣', '🥊', '🥋', '⛸', '🎿', '⛷', '🏂', '🏋️‍♀️', '🏋️‍♂️', '🤺', '🤼‍♀️', '🤼‍♂️', '🤸‍♀️', '🤸‍♂️', '⛹️‍♀️', '⛹️‍♂️', '🤾‍♀️', '🤾‍♂️', '🏌️‍♀️', '🏌️‍♂️', '🏄‍♀️', '🏄‍♂️', '🏊‍♀️', '🏊‍♂️', '🤽‍♀️', '🤽‍♂️', '🚣‍♀️', '🚣‍♂️', '🏇', '🚴‍♀️', '🚴‍♂️', '🚵‍♀️', '🚵‍♂️', '🎽', '🏅', '🎖', '🥇', '🥈', '🥉', '🏆', '🏵', '🎗', '🎫', '🎟', '🎪', '🤹‍♀️', '🤹‍♂️', '🎭', '🎨', '🎬', '🎤', '🎧', '🎼', '🎹', '🥁', '🎷', '🎺', '🎸', '🎻', '🎲', '🎯', '🎳', '🎮', '🎰'],
            'objects': ['🔮', '🎄', '📿', '💎', '💍', '💄', '💅', '👓', '🕶', '🥽', '🥼', '👔', '👕', '👖', '🧣', '🧤', '🧥', '🧦', '👗', '👘', '👙', '👚', '👛', '👜', '👝', '🎒', '👞', '👟', '🥾', '🥿', '👠', '👡', '👢', '👑', '👒', '🎩', '🎓', '📱', '📲', '💻', '⌨️', '🖥', '🖨', '🖱', '🖲', '🕹', '🗜', '💽', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽', '🎞', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙', '🎚', '🎛', '⏱', '⏲', '⏰', '🕰', '⌛️', '⏳', '📡', '🔋', '🔌', '💡', '🔦', '🕯', '🗑', '🛢', '💸', '💵', '💴', '💶', '💷', '💰', '💳', '🧾', '💎', '⚖️', '🔧', '🔨', '⚒', '🛠', '⛏', '🔩', '⚙️', '⛓', '🧰', '🔫', '💣', '🧨', '🧲', '🗡', '⚔️', '🛡', '🚬', '⚰️', '⚱️', '🏺', '🔭', '🔬', '🔮', '🧿', '🧸', '📿', '💈', '⚗️', '🔑', '🗝', '🧶', '🧵', '🧹', '🧺', '🧻', '🚪', '🚿', '🛁', '🛀', '🧼', '🧽', '🧴', '🛎', '🔑', '🗝', '🚪', '🛋', '🛏', '🛌', '🧸', '🖼', '🏮', '🗺', '🧭', '🧱', '⛰️', '🏔️', '🗻', '🏕️', '🏠', '🏡', '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💒', '🗼', '🗽', '⛪', '🕌', '🕍', '⛩️', '🕋', '⛲', '⛺', '🏙️', '🎠', '🎪', '🎭', '🖼️', '🎨', '🧵', '🧶', '🧷', '🧹', '🧺', '🧻', '🧼', '🧽', '🧯', '🚿', '🛁'],
            'symbols': ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐', '⛎', '♈️', '♉️', '♊️', '♋️', '♌️', '♍️', '♎️', '♏️', '♐️', '♑️', '♒️', '♓️', '🆔', '⚛️', '🉑', '☢️', '☣️', '📴', '📳', '🈶', '🈚️', '🈸', '🈺', '🈷️', '✴️', '🆚', '💮', '🉐', '㊙️', '㊗️', '🈴', '🈵', '🈹', '🈲', '🅰️', '🅱️', '🆎', '🆑', '🅾️', '🆘', '❌', '⭕️', '🛑', '⛔️', '📛', '🚫', '💯', '💢', '♨️', '🚷', '🚯', '🚳', '🚱', '🔞', '📵', '🚭', '❗️', '❕', '❓', '❔', '‼️', '⁉️', '🔅', '🔆', '〽️', '⚠️', '🚸', '🔱', '⚜️', '🔰', '♻️', '✅', '🈯️', '💹', '❇️', '✳️', '❎', '🌐', '💠', 'Ⓜ️', '🌀', '💤', '🏧', '🚾', '♿️', '🅿️', '🈳', '🈂️', '🛂', '🛃', '🛄', '🛅', '🚹', '🚺', '🚼', '🚻', '🚮', '🎦', '📶', '🈁', '🔣', 'ℹ️', '🔤', '🔡', '🔠', '🆖', '🆗', '🆙', '🆒', '🆕', '🆓', '0️⃣', '1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟', '🔢', '#️⃣', '*️⃣', '⏏️', '▶️', '⏸', '⏯', '⏹', '⏺', '⏭', '⏮', '⏩', '⏪', '⏫', '⏬', '◀️', '🔼', '🔽', '➡️', '⬅️', '⬆️', '⬇️', '↗️', '↘️', '↙️', '↖️', '↕️', '↔️', '↪️', '↩️', '⤴️', '⤵️', '🔀', '🔁', '🔂', '🔄', '🔃', '🎵', '🎶', '➕', '➖', '➗', '✖️', '♾', '💲', '💱', '™️', '©️', '®️', '〰️', '➰', '➿', '🔚', '🔙', '🔛', '🔝', '🔜', '✔️', '☑️', '🔘', '⚪️', '⚫️', '🔴', '🔵', '🔺', '🔻', '🔸', '🔹', '🔶', '🔷', '🔳', '🔲', '▪️', '▫️', '◾️', '◽️', '◼️', '◻️', '⬛️', '⬜️', '🔈', '🔇', '🔉', '🔊', '🔔', '🔕', '📣', '📢', '👁‍🗨', '💬', '💭', '🗯', '♠️', '♣️', '♥️', '♦️', '🃏', '🎴', '🀄️', '🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚', '🕛', '🕜', '🕝', '🕞', '🕟', '🕠', '🕡', '🕢', '🕣', '🕤', '🕥', '🕦', '🕧']
        };
        
        const currentCategory = 'smileys';
        populateEmojiContainer(emojis[currentCategory]);
        
        $('.emoji-category').click(function() {
            const category = $(this).data('category');
            $('.emoji-category').removeClass('active');
            $(this).addClass('active');
            populateEmojiContainer(emojis[category]);
        });
    }
    
    // Populate emoji container with emojis from a category
    function populateEmojiContainer(emojis) {
        const emojiContainer = $('#emoji-container');
        emojiContainer.empty();
        
        emojis.forEach(emoji => {
            const emojiElement = $('<div class="emoji"></div>').text(emoji);
            emojiElement.click(function() {
                const messageInput = $('#message');
                messageInput.val(messageInput.val() + emoji);
                messageInput.focus();
            });
            emojiContainer.append(emojiElement);
        });
    }
    
    // Voice recording functions
    function startRecording() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    $('#voice-record-button').addClass('recording');
                    $('#voice-record-timer').addClass('show');
                    
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];
                    
                    mediaRecorder.ondataavailable = (e) => {
                        audioChunks.push(e.data);
                    };
                    
                    mediaRecorder.start();
                    isRecording = true;
                    
                    // Start timer
                    recordingDuration = 0;
                    recordingTimer = setInterval(updateRecordingTimer, 1000);
                })
                .catch(error => {
                    console.error('Error accessing microphone:', error);
                    alert('Could not access microphone. Please check your browser permissions.');
                });
        } else {
            alert('Your browser does not support voice recording.');
        }
    }
    
    function stopRecording() {
        if (mediaRecorder && isRecording) {
            mediaRecorder.stop();
            isRecording = false;
            
            // Stop timer
            clearInterval(recordingTimer);
            
            $('#voice-record-button').removeClass('recording');
            $('#voice-record-timer').removeClass('show');
            $('#voice-record-timer').text('0:00');
            
            // Wait for the data to be available
            mediaRecorder.onstop = () => {
                // Automatically send voice message once recording stops
                if (audioChunks.length > 0) {
                    sendMessage();
                }
            };
        }
    }
    
    function updateRecordingTimer() {
        recordingDuration++;
        const minutes = Math.floor(recordingDuration / 60);
        const seconds = recordingDuration % 60;
        $('#voice-record-timer').text(`${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
        
        // Limit recording to 2 minutes
        if (recordingDuration >= 120) {
            stopRecording();
        }
    }
    
    // Function to send voice message
    function sendVoiceMessage() {
        if (!currentDiscussionId || audioChunks.length === 0) return;
        
        const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
        const audioUrl = URL.createObjectURL(audioBlob);
        
        // Save the audio URL in session storage to keep it accessible after refresh
        const audioKey = 'voice_message_' + Date.now();
        sessionStorage.setItem(audioKey, audioUrl);
        
        $.ajax({
            url: '../../controllers/LiveController.php?action=sendMessage',
            method: 'POST',
            data: {
                discussion_id: currentDiscussionId,
                message: '🔊 <audio controls class="audio-message" data-key="' + audioKey + '"><source src="' + audioUrl + '" type="audio/webm"></audio>',
                user_id: currentUserId
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Clear audio chunks
                    audioChunks = [];
                    // Load the new message
                    loadMessages();
                    // Refresh discussions list
                    loadRecentDiscussions();
                } else {
                    alert('Error sending voice message: ' + response.message);
                }
            },
            error: function() {
                alert('Error connecting to server');
            }
        });
    }
    
    // Function to create stars for the background
    function createStars() {
        const starsContainer = document.getElementById('stars');
        const starCount = 100; // Number of stars
        
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            
            // Random positioning
            const x = Math.random() * 100;
            const y = Math.random() * 100;
            
            // Random size
            const size = Math.random() * 3;
            
            // Random animation delay
            const delay = Math.random() * 5;
            
            star.style.left = `${x}%`;
            star.style.top = `${y}%`;
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.animationDelay = `${delay}s`;
            
            starsContainer.appendChild(star);
        }
    }
    
    // Clean up on page unload
    $(window).on('beforeunload', function() {
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
        }
    });
});
    </script>
</body>

</html>