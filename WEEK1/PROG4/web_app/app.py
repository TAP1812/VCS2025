from flask import Flask, render_template, request, redirect, url_for, send_from_directory, session
import os
from werkzeug.utils import secure_filename

app = Flask(__name__)
app.secret_key = "your_secret_key"

UPLOAD_FOLDER = "./images"
ALLOWED_EXTENSIONS = {"txt", "pdf", "png", "jpg", "jpeg", "gif"}

app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER

os.makedirs(UPLOAD_FOLDER, exist_ok=True)

def allowed_file(filename):
    return "." in filename and filename.rsplit(".", 1)[1].lower() in ALLOWED_EXTENSIONS

@app.route("/", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        user = request.form.get("user")
        password = request.form.get("password")
        if user == "user" and password == "password":
            session["user"] = user
            return redirect(url_for("dashboard"))
        return "Tên người dùng hoặc mật khẩu không chính xác"
    return render_template("login.html")

@app.route("/dashboard")
def dashboard():
    if "user" in session:
        images = [f for f in os.listdir(UPLOAD_FOLDER) if f.lower().endswith(("png", "jpg", "jpeg", "gif"))]
        return render_template("dashboard.html", user=session["user"], images=images)

    return redirect(url_for("login"))

@app.route("/upload", methods=["POST"])
def upload_file():
    if "user" not in session:
        return redirect(url_for("login"))

    if request.method == "POST":
        if "file" not in request.files:
            return "Không có tệp nào được chọn"

        file = request.files["file"]

        if file.filename == "":
            return "Không có tệp nào được chọn"

        if file and allowed_file(file.filename):
            filename = secure_filename(file.filename)
            file.save(os.path.join(app.config["UPLOAD_FOLDER"], filename))
            return f"Tệp đã được tải lên thành công tại /images/{filename}"
        return "Loại tệp không được phép"

    return render_template("upload.html")

@app.route("/download/<filename>")
def download_file(filename):
    if "user" not in session:
        return redirect(url_for("login"))

    return send_from_directory(app.config["UPLOAD_FOLDER"], filename)

@app.route("/images/<filename>")
def serve_image(filename):
    return send_from_directory(app.config["UPLOAD_FOLDER"], filename)

@app.route("/logout")
def logout():
    session.pop("user", None)
    return redirect(url_for("login"))

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=1812)