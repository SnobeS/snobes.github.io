// biisit
const songs = [
    "KERZA - Tuulel.mp3",
    "Costi - 5.mp3",
]
const player = document.getElementById('player');

// funktio joka luo listan lauluista ja looppaa sitä kunnes kaikki laulut ovat laitettu
function createSongList() {
    const list = document.createElement('ol');
    // loop
    for(let i = 0; i < songs.length; i++) {
        const item = document.createElement("li");
        item.appendChild(document.createTextNode(songs[i]));
        list.appendChild(item);
    }
    return list
}

const songList = document.getElementById("songList");
songList.appendChild(createSongList());

songList.onclick = function (e) {
    // console.log("moi")
    const source = document.getElementById("source");
    source.src = "songs/" + e.target.innerText;

    document.querySelector("#currentSong").innerText = `Nyt soi: ${e.target.innerText}`;

    player.load()
    player.play()
}

function playAudio() {
    if(player.readyState) {
        player.play();
    }
}

function pauseAudio() {
    player.pause();
}

const slider = document.getElementById("volumeSlider")
slider.oninput = function (e) {
    const volume = e.target.value;
    player.volume = volume;
}

function updateProgress() {
    if(player.currentTime > 0) {
        const progressBar = document.getElementById("progress")
        progressBar.value = (player.currentTime / player.duration) * 100

    }
}