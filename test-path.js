import puppeteer from 'puppeteer';

const browserFetcher = puppeteer.createBrowserFetcher();
const revisionInfo = await browserFetcher.download(puppeteer.browserRevision);
console.log(revisionInfo.executablePath);