const clearDiv = () => {
    document.querySelector('#main').innerHTML = "";
}

const addLoadingAnimation = () => {
    // Clears all the charts from the screen to build new ones
    const mainDiv = document.querySelector('#main');
    const loadingDiv = `
        <div id="loading">
            <img src="images/Pacman.gif"></img>
        </div>`;
    mainDiv.innerHTML = loadingDiv;
}

const make_XHR_request = () => {
    return new Promise((resolve, reject) => {
        const request = new XMLHttpRequest();
    	request.open('GET', 'database.php?getFromDatabase');
    	request.send();
    
    	request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                resolve(request.response);
            }
        }
        request.onerror = function() {
        	reject(request.statusText);
        } 
    });
}

// Need to get last index from array as it is the latest
const buildLineChart = (data, currency) => {
    const div = document.createElement('div');
    const ctx = makeCanvas(currency);
    const header = makeHeader(data.rates[data.rates.length - 1], currency);
    
    div.appendChild(header);
    div.appendChild(ctx);
    
    const myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels : data.timestamps,
            datasets : [{
                label: `${currency} rate`,
                data: data.rates,
            }]
        },
        options: {}
    });
    document.querySelector('#main').appendChild(div);
}

const buildBarChart = (data, currency) => {
    const div = document.createElement('div');
    const ctx = makeCanvas(currency);
    const header = makeHeader(data.rates[data.rates.length - 1], currency);
    
    div.appendChild(header);
    div.appendChild(ctx);
    
    var barChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels : data.timestamps,
            datasets : [{
                label: `${currency} rate`,
                data: data.rates,
            }]
        },
        options: {}
    });
    document.querySelector('#main').appendChild(div);
}

const makeCanvas = (className) => {
    const div = document.createElement('div');
    const canvas = document.createElement('canvas');
    div.className = className;
    const canvasStyles = {
        height : "300px",
        width : "600px",
        "max-width" : "600px",
        "max-height" : "300px"
    }
    Object.entries(canvasStyles).forEach(s => {
        // First index is style name, second is value
        canvas.style[s[0]] = s[1];
    });
    return canvas;
}

const makeHeader = (rate, currency) => {
    const h2 = document.createElement('h2');
    currency = currency[0].toUpperCase() + currency.slice(1);
    h2.innerText = `Current ${currency} rate is ${rate}`;
    return h2;
}

const makeDatabaseQuery = (type = "line") => {
    clearDiv();
    addLoadingAnimation();
    make_XHR_request().then((result) => {
        clearDiv();
        result = JSON.parse(result);
        Object.entries(result).forEach((currencyArray) => {
            const dataObj = {
                timestamps : [],
                rates : []
            }
            currencyArray[1].reverse().forEach(arr => {
                dataObj.timestamps.push(arr.timestamp);
                dataObj.rates.push(arr.rate);
            });
            if (type === "line") {
                buildLineChart(dataObj, currencyArray[0]);
            }
            else {
                buildBarChart(dataObj, currencyArray[0]);
            }
        });
    });
}

const chartSelect = document.querySelector("#chartSelect");
chartSelect.addEventListener("change", (e) => {
    clearDiv();
    addLoadingAnimation();
    if (e.target.value === "bar") {
        makeDatabaseQuery("bar");
    }
    else {
        makeDatabaseQuery();
    }
});

document.onload = makeDatabaseQuery();