'use strict';

const puppeteer = require('puppeteer');

const waitTillHTMLRendered = async (page, timeout = 30000) => {
    const checkDurationMsecs = 1000;
    const maxChecks = timeout / checkDurationMsecs;
    let lastHTMLSize = 0;
    let checkCounts = 1;
    let countStableSizeIterations = 0;
    const minStableSizeIterations = 3;

    while(checkCounts++ <= maxChecks){
        let html = await page.content();
        let currentHTMLSize = html.length;

        let bodyHTMLSize = await page.evaluate(() => document.body.innerHTML.length);

        console.log('last: ', lastHTMLSize, ' <> curr: ', currentHTMLSize, " body html size: ", bodyHTMLSize);

        if(lastHTMLSize != 0 && currentHTMLSize == lastHTMLSize)
            countStableSizeIterations++;
        else
            countStableSizeIterations = 0; //reset the counter

        if(countStableSizeIterations >= minStableSizeIterations) {
            console.log("Page rendered fully..");
            break;
        }

        lastHTMLSize = currentHTMLSize;
        await page.waitForTimeout(checkDurationMsecs);
    }
};

function waitForEndEvent(page) {
    return new Promise((res, rej) => {
        registerConsoleEvent(page, res, rej);
    });
}

function registerConsoleEvent(page, res, rej) {
    page.on('console', function consoleListener(msg) {
        try {
            if (msg.type() == 'timeEnd') {
                if (msg.text().includes('Gata')) {
                    console.log('timeEnd:', msg.text());
                    page.removeListener('console', consoleListener);
                    res();
                }
            }
        } catch (e) {
            rej(e);
        }
    });
}
function delay(time) {
    return new Promise(function(resolve) {
        setTimeout(resolve, time)
    });
}

(async () => {
    if (process.argv.length === 4) {
        let data = {
            'URL': process.argv[2],
            'PDF': process.argv[3],
        }

        const browser = await puppeteer.launch({
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox'
            ]
        });
        const page = await browser.newPage();
        await page.setViewport({
            width: 1000,
            height: 420,
            deviceScaleFactor: 1,
        });
        await page.goto(data.URL, {
            //waitUntil: 'networkidle2',
            //'timeout': 10000,
            'waitUntil':'networkidle2'
        });

        //await new Promise(r => setTimeout(r, 5000));

        //await waitForEndEvent(page);
        //await page.goto(data.PDF, {'timeout': 10000, 'waitUntil':'load'});
        //await waitTillHTMLRendered(page)

        //await waitForDOMToSettle(page);
        //const data = await page.content()

        //await new Promise(r => setTimeout(r, 5000));

        // page.pdf() is currently supported only in headless mode.
        // @see https://bugs.chromium.org/p/chromium/issues/detail?id=753118
        await page.screenshot({
            path: data.PDF,
            fullPage : true,
            quality: 100,
            type: 'jpeg',
        });

        await browser.close();
    }else {
        console.log('Incorrect number of arguments.');
    }
})();

