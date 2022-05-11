<!DOCTYPE html>
<head>
  <title>Test Email</title>
  <style>
    form {
      display: flex;
      flex-direction: column;
      width: 70%;
      margin: auto;
    }
    form input, form textarea, form button {
      padding: 15px;
      margin-bottom: 15px;
      outline: none;
      border: none;
      background-color: #ddd;
    }
    form button {
      background-color: #333;
      color: #fff;
      cursor: pointer;
    }
    h1 {
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>Test Email Javascript</h1>
  <form class="email_form" method="#">
    <input class="name" type="text" placeholder="Tên" />
    <input class="email" type="email" placeholder="Email" />
    <textarea class="msg" cols="5" rows="5" placeholder="Tin nhắn của bạn"></textarea>
    <button type="submit">Send</button>
  </form>

  <!-- SMTPJS v3 -->
  <script src="https://smtpjs.com/v3/smtp.js"></script>
  <script>

    const form = document.querySelector('.email_form');
    
    //function to send email when click on Submit button
    function sendEmailMsg(e){
      e.preventDefault();
        const name = document.querySelector('.name'),
              email = document.querySelector('.email'),
              msg = document.querySelector('.msg');

      // Sending email function
      Email.send({
        SecureToken : "f4907742-9f91-4924-b56b-95dc5d3bed67",
        To : '20520964@gm.uit.edu.vn',
        From : email.value,
        Subject : "Được ăn cả, ngã về không",
        Body : msg.value
      }).then(
        message => alert(message)
      );
    }

    // event listener submit
    form.addEventListener('submit', sendEmailMsg);

  </script>
</body>