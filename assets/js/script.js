function addTopic() {
  const container = document.getElementById('topics_div');
  
  const newDiv = document.createElement('div');
  newDiv.innerHTML = `Add topic: <input name="topic[]" type="text">
                      Add content: <input name="lesson_content[]" type="text">
                        Type:
                        <select name="type[]">
                            <option value="lesson">Lesson</option>
                            <option value="quiz">Quiz</option>
                            <option value="assignment">Assignment</option>
                        </select>`;
  
  container.appendChild(newDiv);
}