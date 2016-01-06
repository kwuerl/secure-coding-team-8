import static org.junit.Assert.*;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.junit.*;

public class AllTanGenerationTests {
	private String target;
	private Double amount;
	private static int pin;

	@BeforeClass
	public static void initTestClass() {
		pin = 123456;
	}

	@Before
	public void initTest() {
		target = "some_target";
		amount = 100.00;
	}

	@Test
	public void validInputShouldGenerateTan() {
		TanGenerator tanGenerator = new TanGenerator();
		/*All inputs passed*/
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for valid input = " + tan);
		assertNotNull(tan);
	}

	@Test
	public void zeroPinShouldNotGenerateTan() {
		/*Pin passed as zero*/
		pin = 0;
		TanGenerator tanGenerator = new TanGenerator();
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for zero pin = " + tan);
		assertNull(tan);
	}

	@Test
	public void invalidPinShouldNotGenerateTan() {
		/*Pin passed as non-6 digit number*/
		pin = 111;
		TanGenerator tanGenerator = new TanGenerator();
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for invalid pin = " + tan);
		assertNull(tan);
	}

	@Test
	public void blankTargetShouldNotGenerateTan() {
		/*Target User name passed as blank*/
		target = "";
		TanGenerator tanGenerator = new TanGenerator();
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for blank target = " + tan);
		assertNull(tan);
	}

	@Test
	public void zeroAmountShouldNotGenerateTan() {
		/*Amount passed as zero*/
		amount = 0.0;
		TanGenerator tanGenerator = new TanGenerator();
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for zero amount = " + tan);
		assertNull(tan);
	}

	@Test
	public void negativeAmountShouldNotGenerateTan() {
		/*Amount passed as negative*/
		amount = -55.00;
		TanGenerator tanGenerator = new TanGenerator();
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for negative amount = " + tan);
		assertNull(tan);
	}

	@Test
	public void largeAmountShouldNotGenerateTan() {
		/*Target User name passed as large value*/
		amount = 9999999999999999999999999999.99;
		TanGenerator tanGenerator = new TanGenerator();
		String tan = tanGenerator.generateTan(pin, target, amount);
		System.out.println("Generated TAN for large amount = " + tan);
		assertNull(tan);
	}

	@Test
	public void shouldNotGenerateDuplicateTAN() {
		/*Valid inputs passed*/
		target = "abc";
		amount = 10.99;
		pin = 123456;
		List<String> tans = new ArrayList<String>();
		TanGenerator tanGenerator = new TanGenerator();
		int i;
		Map<String, Integer> counts = new HashMap<String, Integer>();
		List<String> duplicate_tans = new ArrayList<String>();

		for(i = 0; i < 1000; i++) {
			String tan = tanGenerator.generateTan(pin, target, amount);
			tans.add(tan);
		}

		/*Check for duplicates*/
		for (String str : tans) {
		    if (counts.containsKey(str)) {
		        counts.put(str, counts.get(str) + 1);
		    } else {
		        counts.put(str, 1);
		    }
		}
		System.out.println("Generated TANs are " + tans.toString());
		for (Map.Entry<String, Integer> entry : counts.entrySet()) {
			if(entry.getValue() > 1) {
				duplicate_tans.add(entry.getKey());
			}
		}
		System.out.println("Duplicate TANs count = " + duplicate_tans.size());
		assertEquals(duplicate_tans.size(), 0);
	}
}