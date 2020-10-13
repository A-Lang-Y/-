/*******************************************************************************************************************
*  Set height in row (parentSelector, childSelector, itemsPerRow)                                                  *
*******************************************************************************************************************/
function setEqualHeightInRow(parentSelector, childSelector, itemsPerRow){
    $(parentSelector).each(function(){
        var items = $(this).find(childSelector);
        var itemCount = $(items).size();

        // Set equeal height for items in row
        for (var i = 0; i < itemCount; i += itemsPerRow) {
            // Get max height in row
            var actualMaxHeight = 0;
            for (var j = 0; j < itemsPerRow; j++) {
                var height = $(items).eq(i+j).height();
                if(height > actualMaxHeight) actualMaxHeight = height;
            }
            // Set height in row
            for (var j = 0; j < itemsPerRow; j++) {
                $(items).eq(i+j).height(actualMaxHeight);
            }
        }

    });
}
