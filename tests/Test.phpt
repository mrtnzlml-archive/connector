<?hh

namespace Tests;

use Tester\Assert;

require __DIR__ . '/bootstrap.php';

class Test extends \Tester\TestCase {

  public function testIt()
  {
    Assert::true(TRUE);
  }

}

(new Test())->run();
