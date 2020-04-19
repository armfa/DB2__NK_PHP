<?

//?
//Hier müssen die Berechungsfunktionen rein. 
//

class ErgebnisController extends Ergebnis
{

    //ToDo minimum, maximum, durchschnitt, von DB berechnen lassen

    private static function calculateStandardabweichung($valueArray)
    {       
            //not tested yet http://www.monkey-business.biz/2985/php-funktion-standardabweichung-stabw/
            $sum = array_sum($valueArray);
            $count = count($valueArray);
            $mean =	$sum / $count;
            $result = 0;
            foreach ($valueArray as $value)
                $result += pow($value - $mean, 2);
            unset($value);			
            $count = ($count == 1) ? $count : $count - 1;
            return sqrt($result / $count);      
    }

    public function calculateErgebnis()
    {
    }
}
