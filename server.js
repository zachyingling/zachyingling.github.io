require("dotenv").config();
const express = require("express");
const app = express();
const path = require("path");
const PORT = process.env.PORT || 8080;

const nodemailer = require("nodemailer");

app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static("public"));

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "index.html"));
});

app.get("/redirect", (req, res) => {
  res.sendFile(path.join(__dirname, "redirect.html"));
})

app.post("/api/contact-form", (req, res) => {
  let email = req.body.email;
  let message = req.body.message;
  let firstName = req.body.name;
  let lastName = req.body.surname;

  let transporter = nodemailer.createTransport({
    service: "gmail",
    auth: {
      user: process.env.GOOGLE_EMAIL,
      pass: process.env.GOOGLE_PASS
    }
  });

  let mailOptions = {
    from: email,
    to: process.env.GOOGLE_EMAIL,
    subject: "Email from Portfolio",
    text: "From: " + email + "\nName: " + firstName + " " + lastName + "\n\n" + message
  };

  transporter.sendMail(mailOptions, (err, data) => {
    if (err) {
      res.send("Error: " + err);
    } else {
      res.redirect("/redirect");
    }
  });
});

app.listen(PORT, function() {
  console.log("App listening on PORT: " + PORT);
});
