<?php

namespace Core;


use \Closure;
use \Exception;
use Core\Middleware\IMiddlewareFactory;
use Core\Middleware\MiddlewareFactory;

/**
 * <b>Rout</b>:
 * Classe Responsável por todo o gerenciamento
 * de rotas do sistema, trabalha sobre arquitetura MVC.
 * @author Weydans Campos de Barros, 06/03/2019.
 */
class Route {

    private $url;
    private $route;
    private $group;
    private $result = null;
    private $middlewareFactory;
    private $request;

    /**
     * Pega o path da url que o usuario digitou
     * e configura propriedade $url com o valor obtido.
     */
    public function __construct(string $baseUri = null, IMiddlewareFactory $middlewareFactory = null) 
    {
        $this->url               = strip_tags(trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $this->middlewareFactory = !empty($middlewareFactory) ? $middlewareFactory : new MiddlewareFactory();
        $this->clearGroup();

        if ($baseUri) {
            $this->url = str_replace($baseUri, '', $this->url);
        }

        // var_dump($this->url);
    }


    /**
     * group()
     * 
     * Cria grupos de rotas com caminhos semelhantes
     * @param string  $group Prefixo do grupo de rotas
     * @param array   $middlewares Middlewares do grupo
     * @param Closure $callback Açoes realizadas dentro do grupo
     */
    public function group(string $group, array $middlewares = [], Closure $callback)
    {
        $this->group = $group;

        if (!empty($middlewares)) {
            $this->middleware($middlewares, $callback);
            $this->clearGroup();
            return;
        }

        $callback($this);
        $this->clearGroup();
    }


    /**
     * middleware()
     * 
     * Executa middlewares informados por parâmetro
     * @param array   $middlewares Middlewares a serem chamados
     * @param Closure $callback Açoes a serem realizadas 
     */
    public function middleware(array $middlewares, Closure $callback = null)
    {
        $this->request = $_REQUEST;

        try {
            foreach ($middlewares as $middleware) {
                $middleware = $this->middlewareFactory->build($middleware);
                $middleware->execute($this->request);
            }

            if (!empty($callback)) {
                $callback($this);
            }

            $this->middleware = [];

        } catch (Exception $e) {
            throw new Exception($e->getMessage());            
        }
    }

    /**
     * Sinaliza metodo get
     */
    public function get(string $route, Closure $callback, array $middlewares = [])
    {  
        $route = $this->group . $route;

        $this->callMiddlewares($middlewares);

        if (empty($_POST)) {
            $this->route($route, $callback);
        }
    }

    /**
     * Sinaliza metodo post
     */
    public function post(string $route, Closure $callback, array $middlewares = [])
    {  
        $route = $this->group . $route;

        $this->callMiddlewares($middlewares);

        if ($_POST){
            $this->route($route, $callback);
        }
    }

    /**
     * Sinaliza metodo put
     */
    public function put(string $route, Closure $callback, array $middlewares = [])
    {  
        $route = $this->group . $route;

        $this->callMiddlewares($middlewares);

        $this->route($route, $callback);
    }

    /**
     * Sinaliza metodo delete
     */
    public function delete(string $route, Closure $callback, array $middlewares = [])
    {  
        $route = $this->group . $route;

        $this->callMiddlewares($middlewares);

        $this->route($route, $callback);
    }

    /**
     * <b>run</b>:
     * Realiza a exibição da view, 
     * caso rota inválida retorna página 404.
     *
     * @param objeto $_404 recebe página 404 personalizada.
     */
    public function run($_404 = null) 
    {
        if ($this->result === null && !empty($_404)){
            $_404->show();

        } elseif ($this->result === null) {
            echo '<div>';
            echo '<h1 style="margin: 0; padding: 0;">404</h1>';
            echo '<h3 style="margin: 0; padding: 0;">Página não encontrada!</h3>';
            echo '</div>';
        }
    }


    /**
     * <b>route</b>: Realiza todo o controle de rotas do sistema.
     *
     * @param string $method Ex(get, post, delete...)
     * @param string $route Rota a ser definida pelo programador
     * @param type $callback Recebe uma função callback com a ação (Controller)
     * que deve ser executado. Deve retornar uma string com Html a ser exibido.
     */
    private function route(string $route, $callback) 
    {
        $this->route = $route;

        $urlArray = explode('/', $this->url);
        $routeArray = explode('/', $this->route); 
        
        $param = array();
        
        if ($this->route === $this->url && $this->result === null){
            $callback();
            $this->result = true;
            die;

        } elseif (count($routeArray) === count($urlArray)) {

            $j = 0;
            
            for ($i = 0; $i < count($urlArray); $i++) {

                // Verifica se valor dos indices são diferentes
                // e se o(s) parametro(s) passado(s) inicia(m) e termina(m) com "{}".
                if (
                    ($urlArray[$i] !== $routeArray[$i]) 
                    && 
                    (substr($routeArray[$i], 0, 1) === '{') 
                    && 
                    (substr($routeArray[$i], strrpos($routeArray[$i], '}'), 1) === '}')) 
                {

                    $routeArray[$i] = $urlArray[$i];

                    $key = "param{$j}";
                    $param[$key] = $urlArray[$i];

                    $j++;
                }
            }

            $this->route = implode('/', $routeArray);
            
            if ($this->result === null) {
                $this->setNumParam($param, $callback);
            }
        }
    }

    /**
     * <b>setNumParam</b>: Verifica se a rota informada pelo usuario
     * corresponde a uma rota válida do sistema. Verifica se existem
     * parâmetros e realiza a passagem dinamicamente de cada parametro.
     *
     * @param type $param Recebe um array associativo com os valores dos parâmetros.
     * @param type $callback Recebe a closure a ser executada.
     */
    private function setNumParam($param, $callback) 
    {
        $numParams = count($param);

        if ($this->route === $this->url && $numParams > 0) {

            extract($param);

            if ($numParams == 1) {
                $callback($param0);

            } elseif ($numParams == 2) {
                $callback($param0, $param1);

            } elseif ($numParams == 3) {
                $callback($param0, $param1, $param2);

            } elseif ($numParams == 4) {
                $callback($param0, $param1, $param2, $param3);

            } elseif ($numParams == 5) {
                $callback($param0, $param1, $param2, $param3, $param4);

            } elseif ($numParams > 5) {
                $this->result = Msg::setMsg('Número de parâmetros para rotas deve ser menor ou igual a 5.', ERROR);
            }

            $this->result = true;

            die;
        }
    }


    /**
     * callMiddlewares()
     * 
     * Centraliza chamada interna ao método middleware
     * @param array $middlewares Middlewares 
     */
    private function callMiddlewares(array $middlewares)
    {
        if (!empty($middlewares)) {
            $this->middleware($middlewares);
        }
    }


    /**
     * clearGroup()
     * 
     * Sonfigura atributo grupo como uma string vazia
     */
    private function clearGroup()
    {
        $this->group = '';
    }
}
