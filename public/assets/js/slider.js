var Slider = {
    init:function(){
        this.images = ["../img/nba1.jpg","../img/nba2.jpg","../img/nba3.jpg"];
        this.imageNumber = 0;
        this.imageLenght = this.images.length -1;
    },
    chgImg:function(x){
        this.imageNumber += x;
        if(this.imageNumber > this.imageLenght){
            this.imageNumber =0;
        }
        if(this.imageNumber < 0) {
            this.imageNumber = this.imageLenght;
        }

        document.getElementById("slideshow").src = this.images[this.imageNumber];
        return false;
    },
    keyImg:function(event){
        var key = event.keyCode;
        if (key == 37){
            this.chgImg(-1);
        }
        if (key == 39){
            this.chgImg(1);
        }
    }
};
