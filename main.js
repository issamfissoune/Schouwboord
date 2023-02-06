window.addEventListener('load', init);

let apiUrl = 'http://localhost/schouwboord/webservice/data.php'
let board;
let boardCard;


function init() {
    board = document.getElementById('schouwboord')
    getActivity(apiUrl, createBoard);


}

function getActivity(url) {
    fetch(url)
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.statusText)
            }
            return response.json();

        })
        .then(createBoard)
        .catch(ajaxErrorHandler);
}

function createBoard(data) {

    // console.log(data.id)
    // console.log(data.name)
    for (let activity of data) {
        console.log(data);
        boardCard = document.createElement('div');
        boardCard.classList.add('dashboard-card');
        boardCard.dataset.name = boardCard.name;
        boardCard.dataset.id = activity.id

        board.appendChild(boardCard)


        //fill board

        //objects
        let title = document.createElement('h2')
        let minorDetails = document.createElement("h3")
        let activityTitle = document.createElement('h3')
        let info = document.createElement('button');
        let upVote = document.createElement('button');
        let participate = document.createElement('button');
        let voteCounter = document.createElement("p")

        //content of the objects
        title.innerHTML = `#${activity.id} ${activity.naam}`;
        minorDetails.innerHTML = `${activity.datum}`
        activityTitle.innerHTML = `${activity.details}`
        info.innerHTML = "meer info";
        upVote.innerHTML = "Vote";
        participate.innerHTML = "deelnemen"
        voteCounter.innerHTML = `${activity.vote}`

        //appending

        boardCard.appendChild(title)
        boardCard.appendChild(minorDetails)
        boardCard.appendChild(activityTitle)
        boardCard.appendChild(info)
        boardCard.appendChild(upVote)
        boardCard.appendChild(participate)
        boardCard.appendChild(voteCounter)


        //datasets
        upVote.dataset.id = activity.id;
        upVote.dataset.vote = activity.vote;
        participate.dataset.id = activity.id



        //eventlisteners
        upVote.addEventListener('click', voteCounterHandler)
        participate.addEventListener("click", participateClickHandler)
        // participate.addEventListener('click', removeParticipation)



        //attributes and classlists
        upVote.classList.add("like")
        participate.setAttribute("id", "participate_id" + activity.id)
        voteCounter.setAttribute("id", "vote_id_" + activity.id)




        console.log(participate.dataset.id)







    }
}

function ajaxErrorHandler(data) {
    console.log(data)
    let error = document.createElement('div')
    error.classList.add('error');
    error.innerHTML = "ERROR!!!";
    board.before(error);
}


function voteCounterHandler(e) {
    let add = document.getElementById("vote_id_" + e.target.dataset.id)
    let vote = e.target.dataset.vote++
    add.innerHTML = `${vote}`;
}

function participateClickHandler(e){
    console.log(e.target.dataset.id);

    if (e.target.nodeName !== 'BUTTON'){
        return
    }

    let selected = document.querySelector(`.dashboard-card[data-id="${e.target.dataset.id}"]`)
    // console.log(selected)
    selected.classList.toggle('open');

    if (selected.classList.contains("open")){
        e.target.innerHTML = "uitschrijven"

    }else{
        e.target.innerHTML = "deelnemen"
    }

}


// function removeParticipation(e){
//     console.log(e.target.dataset.id)
//
//     let deelnemen = document.querySelector(`.dashboard-card .open[data-id="${e.target.dataset.id}"]`)
//
//     if (deelnemen.classList.contains("open") )
//     deelnemen.classList.remove('open');
// }

