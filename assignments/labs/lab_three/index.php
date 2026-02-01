<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3 </title>
</head>

<body>
    <header>
        <h1>Bake It Til You Make It Bakery</h1>
    </header>
<main>
  <h2>Contact & Feedback</h2>
  <form action="process.php" method="post">
    <!-- Contact Form, default values placed for easier testing -->
    <fieldset>
      <legend>Customer Information</legend>
        <label for="first_name" >First name</label>
        <input required type="text" id="first_name" name="first_name"       value="Ryan">

        <label for="last_name">Last name</label>
        <input required type="text" id="last_name" name="last_name"         value="Reynolds">

        <label for="email">Email Address</label>
        <input type="email" required type="text" id="email" name="email"        value="test@mail.com">

        <H3>Message</H3>
        <textarea required id="message" name="message" rows="8" cols="50" placeholder="Ask a question or leave feedback here!
🤨 I don't have all day
≤))≥
_|\_" style="white-space: pre-line"></textarea>
        <br/>
        <input type="submit" value="Submit"> <input type="reset" value="Reset">
    </fieldset>