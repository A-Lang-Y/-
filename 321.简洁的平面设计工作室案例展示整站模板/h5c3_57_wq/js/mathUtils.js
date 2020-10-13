function RandRange(min, max, isRound) {
        var res;
        if (isRound) {
            res = Math.round(Math.random()*(max-min)+min);
            
            }else{
                res = Math.random()*(max-min)+min;
                
           }

        return res;
}