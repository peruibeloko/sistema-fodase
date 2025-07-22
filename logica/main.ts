const height = getPositiveInteger('Altura da pirâmide:');
const char = getSingleChar('Caractere:');
const qty = getRepetitions();
const inverted = confirm('Inverter as pirâmides?');

// ? Change this to a visible character to aid in debugging
const SPACER = '.';

// ? We start at the top layer because we print downwards
for (let layer = height; layer >= 1; layer--) {
  // ? Starts small, grows with each layer down
  const grow = (c: string) => c.repeat(height - layer);

  // ? Starts big, shrinks with each layer down
  const shrink = (c: string) => c.repeat(layer - 1);

  // ? Spacers start small with inverted pyramids, but start big normally
  const spacer = inverted ? grow(SPACER) : shrink(SPACER);
  
  // ? Sections start big with inverted pyramids, but start small normally
  const section = inverted ? shrink(char) : grow(char);

  /*
  ? Each layer can be broken down like this:
  ? <space before the left portion> <left portion> <center column>
  ? And we mirror this arrangement to the right

  ? Depending on how many pyramids we need, we repeat each layer to the right
  ? during printing.
  */
  console.log(`${spacer}${section}${char}${section}${spacer}`.repeat(qty));
}

/**
 ** Prompts the user for a positive integer. Loops until a correct value is given
 * @param text Prompt for the user
 * @returns A positive integer, guaranteed
 */
function getPositiveInteger(text: string) {
  const getFractionalPart = (n: number) => n - Math.trunc(n);

  let input = Number(prompt(text));

  while (input <= 0 || getFractionalPart(input) !== 0) {
    console.log('Valor inválido, use apenas números inteiros positivos');
    input = Number(prompt(text));
  }

  return input;
}

/**
 ** Prompts the user for a single character. Loops until a correct value is given
 * @param text Prompt for the user
 * @returns A single visible character, guaranteed
 */
function getSingleChar(text: string) {
  let char = prompt(text, '')!;

  while (!/^\S$/.test(char)) {
    console.log('Valor inválido, forneça um único caractere visível');
    char = prompt(text, '')!;
  }

  return char;
}

/**
 ** Prompts the user for a valid pyramid count. Loops until a correct value is given
 * @param text Prompt for the user
 * @returns Either the value `1`, `2` or `3`
 */
function getRepetitions() {
  let repetitions = getPositiveInteger('Repetições:');

  while (![1, 2, 3].includes(repetitions)) {
    console.log('Você só pode repetir a pirâmide de 1 a 3 vezes');
    repetitions = getPositiveInteger('Repetições:');
  }

  return repetitions;
}
