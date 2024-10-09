using System;

namespace ArithmeticOperations
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("Enter the first positive integer:");
            int num1 = int.Parse(Console.ReadLine());

            Console.WriteLine("Enter the second positive integer:");
            int num2 = int.Parse(Console.ReadLine());

            int sum = num1 + num2;
            int difference = num1 - num2;
            int product = num1 * num2;

            Console.WriteLine($"Sum: {sum}");
            Console.WriteLine($"Difference: {difference}");
            Console.WriteLine($"Product: {product}");

            if (num1 < num2)
            {
                Console.WriteLine("The first number is smaller than the second number.");
            }

            Console.ReadLine();
        }
    }
}