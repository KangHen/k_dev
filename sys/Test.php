class TestClass
{   
    public static $currentValue;

    private static $_instance = null;

    private function __construct () { }

    public static function getInstance ()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function toValue($value) {
        self::$currentValue = $value;
        return $this;
    }

    public function add($value) {
        self::$currentValue = self::$currentValue + $value;
        return $this;
    }

    public function subtract($value) {
        self::$currentValue = self::$currentValue - $value;
        return $this;
    }

    public function result() {
        return self::$currentValue;
    }
}

// Example Usage:
$result = TestClass::getInstance ()
    ->toValue(5)
    ->add(3)
    ->subtract(2)
    ->add(8)
    ->result();



    class Calculator
{   
    public static $value = 0;

    protected static $onlyInstance;

    protected function __construct () 
    {
        // disable creation of public instances 
    }

    protected static function getself()
    {
        if (static::$onlyInstance === null) 
        {
            static::$onlyInstance = new Calculator;
        }

        return static::$onlyInstance;
    }

    /**
     * add to value
     * @param numeric $num 
     * @return \Calculator
     */
    public static function add($num) 
    {
        static::$value += $num;
        return static::getself();
    }

    /**
     * substruct
     * @param string $num
     * @return \Calculator
     */
    public static function subtract($num) 
    {
        static::$value -= $num;
        return static::getself();
    }

    /**
     * multiple by
     * @param string $num
     * @return \Calculator
     */
    public static function multiple($num) 
    {
        static::$value *= $num;
        return static::getself();
    }

    /**
     * devide by
     * @param string $num
     * @return \Calculator
     */
    public static function devide($num) 
    {
        static::$value /= $num;
        return static::getself();
    }

    public static function result()
    {
        return static::$value;
    }
}
Example:

echo Calculator::add(5)
        ->subtract(2)
        ->multiple(2.1)
        ->devide(10)
    ->result();