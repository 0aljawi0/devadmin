class UploadAdapter {
    constructor(loader, url, asset) {
        this.asset = asset;
        this.url = url;
        this.loader = loader;
    }

    async upload() {
        const data = new FormData();
        data.append("file", await this.loader.file);

        const res = await window.axios({
            url: this.url,
            method: "POST",
            data,
            withCredentials: true,
        });

        return {
            default: this.asset + '/' + res.data.url,
        };
    }
}

export default UploadAdapter;
