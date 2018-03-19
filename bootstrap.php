<?php
class Ps4Autoloader
{
    private $rules;
    
    public function add(string $prefix, string $path): self
    {
        $this->rules = ['prefix' => $prefix, 'path' => $path];
        return $this;
    }
    
    public function register()
    {
        spl_autoload_register(function ($class) {

            $prefix = $this->rules['prefix'];
            
            //direktorija
            $path = $this->rules['path'];    
            
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                //jei nesutampa klases, nutraukti
                return;
            }
            
            // gauti relative klases pavadinima
            $relative_class = substr($class, $len);
            
            
            $file = $path . str_replace('\\', '/', $relative_class) . '.php';
            
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}
$autoloader = new Ps4Autoloader();
$autoloader
    ->add('Nfq\\Academy\\Homework\\', __DIR__.'/src/')
    ->register();