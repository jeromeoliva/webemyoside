var StarCheckBox = new StarCheckBox();

function StarCheckBox()
{
    this.Verify = function(control,exp,message)
    {
    };
    
    this.Enter = function(element)
    {
        //Recuperation du parent
        parent = element.parentNode;
        
        //Recuperation des image
        stars = parent.getElementsByTagName("img");
        
        for(i= 0; i < stars.length; i++)
        {
            if(stars[i].name <= element.name)
            {
                stars[i].src = stars[i].src.replace("off.png", "on.png");
            }
        }
    };
    
    this.Leave = function(element)
    {
        if(element.title == "")
        {
            //Recuperation du parent
            parent = element.parentNode;

            //Recuperation des image
            stars = parent.getElementsByTagName("img");

            for(i= 0; i < stars.length; i++)
            {
                if(stars[i].name <= element.name)
                {
                    stars[i].src = stars[i].src.replace("on.png", "off.png");
                }
            }
        }
    };
    
    
    this.Select = function(element)
    {
        alert(element.title);
        element.title = "select";
        alert(element.title);
    }
};