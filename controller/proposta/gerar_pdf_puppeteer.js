// controller/contrato/gerar_pdf_puppeteer.js
import puppeteer from "puppeteer";
import path from "path";
import fs from "fs";

const args = process.argv.slice(2);
if (args.length < 2) {
  console.error("Uso: node gerar_pdf_puppeteer.js <token> <nomeArquivo.pdf>");
  process.exit(1);
}

const token = args[0];
const nomeArquivo = args[1];
const chromePath = "/usr/bin/google-chrome";

const baseUrl = "http://localhost/Contrato/view/proposta/page_gerarProposta.php";
const url = `${baseUrl}?token=${encodeURIComponent(token)}`;

const outputDir = path.resolve(process.cwd(), "../../assets/PropostaPDF_save");
if (!fs.existsSync(outputDir)) fs.mkdirSync(outputDir, { recursive: true });

const outputPath = path.join(outputDir, nomeArquivo);

(async () => {
  let browser;
  try {
    browser = await puppeteer.launch({
      headless: true,
      executablePath: chromePath,
      args: ["--no-sandbox", "--disable-setuid-sandbox"]
    });

    const page = await browser.newPage();
    await page.setViewport({ width: 1200, height: 1600, deviceScaleFactor: 1.5 });
    await page.goto(url, { waitUntil: "networkidle0" });
    await new Promise(r => setTimeout(r, 500));

    await page.pdf({
      path: outputPath,
      format: "A4",
      printBackground: true,
      margin: { top: "10mm", bottom: "10mm", left: "10mm", right: "10mm" }
    });

    console.log(`✅ PDF gerado com sucesso!`);
  } catch (err) {
    console.error("Erro no Puppeteer:", err);
    process.exit(1);
  } finally {
    if (browser) await browser.close();
  }
})();

