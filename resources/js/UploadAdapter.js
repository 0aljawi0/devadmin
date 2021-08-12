class UploadAdapter {
    constructor(loader, url, asset) {
        this.asset = asset;
        this.url = url;
        this.loader = loader;
    }

    async upload() {
        const data = new FormData();
        data.append("image", await this.loader.file);

        const res = await window.axios({
            url: this.url,
            method: "POST",
            data,
        });

        return {
            default: this.asset + '/images/' + res.data.url,
        };
    }
}

export default UploadAdapter;
