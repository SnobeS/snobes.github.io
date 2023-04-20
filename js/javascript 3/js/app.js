var sentenceNode = document.getElementById("lorem");
var sentence = sentenceNode.innerText;
console.log("Sentence:", sentence);

var upperSentence = sentence.toUpperCase();
var lowerSentence = sentence.toLowerCase();
var firstTenChars = sentence.substr(10);

var allWords = sentence.split(" ");
console.log(allWords);
var bracketWords = "(" + allWords.join(")(") + ")" 

/* input */

var name = prompt("What is your name?");
var h3Node = document.getElementById("customInput");
h3Node.innerText = name;
console.log(name);