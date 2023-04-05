<?php

namespace App\Doctrine\Function;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class LevenshteinFunction extends FunctionNode
{
    public static $functionName = 'LEVENSHTEIN';

    public $firstStringExpression = null;
    public $secondStringExpression = null;

    public function getSql(SqlWalker $sqlWalker): string {
        return self::$functionName.'(' .
            $this->firstStringExpression->dispatch($sqlWalker) . ', ' .
            $this->secondStringExpression->dispatch($sqlWalker) . ')';
    }

    /**
     * @throws QueryException
     */
    public function parse(Parser $parser): void {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstStringExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->secondStringExpression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
