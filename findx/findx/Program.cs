using System;

namespace FindMaxExample
{
    class Program
    {
        static int FindMax(int a, int b)
        {
            return a > b ? a : b;
        }

        static void Main(string[] args)
        {
            Console.Write("Enter the first number: ");
            int num1 = int.Parse(Console.ReadLine());

            Console.Write("Enter the second number: ");
            int num2 = int.Parse(Console.ReadLine());

            int maximum = FindMax(num1, num2);
            Console.WriteLine("The larger number is: " + maximum);
        }
    }
}
 


